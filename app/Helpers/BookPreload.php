<?php


namespace App\Helpers;


use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookCharacter;
use App\Models\Character;

class BookPreload
{
    protected $helper;

    public function __construct(HttpHelper $helper)
    {
        $this->helper = $helper;
    }

    public function loadBooks($numberOfBooks){
        for ($i = 1; $i <= $numberOfBooks; $i++) {
            $book = $this->helper->getBook($i);
            if ($book) {
                $this->saveBook($book);
            }
        }
    }

    private function saveBook($book)
    {
        $result = Book::firstOrCreate(['name' => $book->name],
            [
                'isbn' => $book->isbn,
                'publisher' => $book->publisher,
                'country' => $book->country,
                'mediaType' => $book->mediaType,
                'url' => $book->url,
                'numberOfPages' => $book->numberOfPages,
                'released' => $book->released
            ]);

        $authors = $book->authors;
        foreach ($authors as $auth) {
            $this->saveAuthor($result, $auth);
        }

        $characters = $book->characters;
        foreach ($characters as $char) {
            $character = $this->helper->getCharacter($char);
            if ($character) {
                $this->saveCharacter($result, $character);
            }
        }
    }

    private function saveAuthor($book, $author)
    {
        $author = Author::firstOrCreate(['name' => $author]);
        BookAuthor::firstOrCreate(['author_id' => $author->id, 'book_id' => $book->id]);
    }

    private function saveCharacter($book, $character)
    {
        $result = Character::firstOrCreate(['url' => $character->url], [
            'url' => $character->url,
            'name' => $character->name,
            'gender' => $character->gender,
            'culture' => $character->culture,
            'father' => $character->father,
            'mother' => $character->mother,
            'spouse' => $character->spouse
        ]);

        BookCharacter::firstOrCreate(['book_id' => $book->id, 'character_id' => $result->id]);
    }
}
