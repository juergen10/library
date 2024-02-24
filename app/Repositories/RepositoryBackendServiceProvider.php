<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryBackendServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(BookAuthorRepositoryInterface::class, BookAuthorRepository::class);
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(ReturnBookRepositoryInterface::class, ReturnBookRepository::class);
    }
}
