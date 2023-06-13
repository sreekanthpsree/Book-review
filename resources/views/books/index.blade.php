@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2x1">Books</h1>
    <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
        <input type="text" name="title" class="input h-10" placeholder="Search by title" value="{{ request('title') }}">
        <input type="hidden" value="{{ request('filter') }}" name="filter">
        <button type="submit" class="btn h-10">Search</button>
        <a href="{{ route('books.index') }}" class="btn h-10">Clear</a>
    </form>
    <div>
        <div class="filter-container mb-4 flex">
            @php
                $filters = [
                    '' => 'Latest',
                    'popular_last_month' => 'Popular last month',
                    'popular_last_6months' => 'Popular last 6 months',
                    'highest_rated_last_month' => 'Highest rated last month',
                    'highest_rated_last_6month' => 'Highest rated last 6 month',
                ];
            @endphp
            @foreach ($filters as $key => $label)
                <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}"
                    class="{{ request('filter') === $key || (request('filter') == null && $key === '') ? 'filter-item-active' : 'filter-item' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>
    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author }}</span>
                        </div>
                        <div class="flex-col">
                            <div>
                                <div class="book-rating">
                                    {{ number_format($book->reviews_avg_rating, 1) }}
                                    <x-star_rating :rating="$book->reviews_avg_rating" />
                                </div>
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }}{{ Str::plural(' review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a class="reset-link" href="{{ route('books.index') }}">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
