<?php

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('skenario 1: buka / tanpa login menampilkan 6 artikel terbaru, gambar, nama penulis, dan tautan login/register', function () {
    $user = User::factory()->create(['name' => 'Penulis Satu']);
    Article::factory(8)->for($user)->create();

    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('Login');
    $response->assertSee('Register');
    $response->assertSee('Penulis Satu');
});

test('skenario 2: klik judul berita membuka halaman detail tanpa login dengan slug', function () {
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create([
        'title' => 'Judul Artikel Menarik',
        'slug' => 'judul-artikel-menarik-abc123',
        'body' => 'Isi dari artikel menarik ini.',
    ]);

    $response = $this->get(route('articles.show', $article));

    $response->assertStatus(200);
    $response->assertSee('Judul Artikel Menarik');
    $response->assertSee('Isi dari artikel menarik ini.');
    $this->assertStringContainsString('judul-artikel-menarik-abc123', route('articles.show', $article));
});

test('skenario 3: buka /dashboard tanpa login dialihkan ke halaman login', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('skenario 4: login sebagai praktikan@example.com masuk ke dashboard dengan angka total & artikel kamu yang benar', function () {
    $praktikan = User::factory()->create([
        'name' => 'Praktikan',
        'email' => 'praktikan@example.com',
        'password' => bcrypt('password'),
    ]);
    $otherUser = User::factory()->create();

    Article::factory(3)->for($praktikan)->create();
    Article::factory(2)->for($otherUser)->create();

    $response = $this->actingAs($praktikan)->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Praktikan');
    // Total artikel: 5, Artikel praktikan: 3
    $response->assertSee('5');
    $response->assertSee('3');
});

test('skenario 5: menu artikel menampilkan 10 artikel per halaman dengan pagination', function () {
    $user = User::factory()->create();
    Article::factory(15)->for($user)->create();

    $response = $this->actingAs($user)->get(route('articles.index'));

    $response->assertStatus(200);
    $response->assertViewHas('articles');
    $articles = $response->viewData('articles');
    expect($articles->count())->toBe(10);
    expect($articles->total())->toBe(15);
    $response->assertSee('pagination');
});

test('skenario 6: tambah artikel dengan judul dan isi tanpa url gambar menghasilkan placeholder', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('articles.store'), [
        'title' => 'Artikel Baru Tanpa Gambar',
        'body' => 'Konten artikel baru yang valid.',
        'image' => '',
    ]);

    $response->assertRedirect(route('articles.index'));
    $response->assertSessionHas('success');

    $article = Article::where('title', 'Artikel Baru Tanpa Gambar')->first();
    expect($article)->not->toBeNull();
    expect($article->image)->toBeNull();
    expect($article->image_url)->toContain('picsum.photos');
});

test('skenario 7: tambah artikel dengan url gambar tidak valid ditolak validasi', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->from(route('articles.create'))->post(route('articles.store'), [
        'title' => 'Artikel Gagal Gambar',
        'body' => 'Konten artikel.',
        'image' => 'abc',
    ]);

    $response->assertRedirect(route('articles.create'));
    $response->assertSessionHasErrors('image');
});

test('skenario 8: edit artikel milik sendiri berhasil dan slug tidak berubah', function () {
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create([
        'title' => 'Judul Awal',
        'slug' => 'judul-awal-fixed12',
    ]);

    $response = $this->actingAs($user)->put(route('articles.update', $article), [
        'title' => 'Judul Berubah Total',
        'body' => 'Isi artikel diperbarui.',
        'image' => null,
    ]);

    $response->assertRedirect(route('articles.index'));
    $article->refresh();
    expect($article->title)->toBe('Judul Berubah Total');
    expect($article->slug)->toBe('judul-awal-fixed12');
});

test('skenario 9: kosongkan url gambar pada edit mengembalikan gambar ke placeholder', function () {
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create([
        'image' => 'https://example.com/foto-lama.jpg',
    ]);

    $this->actingAs($user)->put(route('articles.update', $article), [
        'title' => $article->title,
        'body' => $article->body,
        'image' => '',
    ]);

    $article->refresh();
    expect($article->image)->toBeNull();
    expect($article->image_url)->toContain('picsum.photos');
});

test('skenario 10: hapus artikel milik sendiri berhasil dengan pesan sukses', function () {
    $user = User::factory()->create();
    $article = Article::factory()->for($user)->create();

    $response = $this->actingAs($user)->delete(route('articles.destroy', $article));

    $response->assertRedirect(route('articles.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('articles', ['id' => $article->id]);
});

test('skenario 11: daftar akun kedua, buka artikel akun pertama, tombol edit/hapus tidak tampil', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $article = Article::factory()->for($user1)->create();

    $response = $this->actingAs($user2)->get(route('articles.index'));
    $response->assertStatus(200);
    $response->assertDontSee(route('articles.edit', $article));
});

test('skenario 12: akun kedua membuka manual /articles/{slug}/edit milik akun pertama mendapat 403', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $article = Article::factory()->for($user1)->create();

    $response = $this->actingAs($user2)->get(route('articles.edit', $article));

    $response->assertStatus(403);
});

test('skenario 13: logout mengembalikan ke home dan menu berubah menjadi login/register', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('home'));
    $this->assertGuest();

    $home = $this->get(route('home'));
    $home->assertSee('Login');
    $home->assertSee('Register');
});
