<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\BookPreload;
use App\Models\Book;
use App\Models\BookCharacter;
use App\Models\Character;
use App\Models\Comment;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $responseHelper;

    public function __construct(ApiResponse $responseHelper)
    {
        $this->responseHelper = $responseHelper;
    }

    public function index()
    {
        return $this->responseHelper->processResponse(null, 'Welcome!!!');
    }

    public function getBooks()
    {
        $books = Book::withCount(['authors', 'comments', 'characters'])->with(['authors'])->orderBy('released', 'DESC')->get();

        return $this->responseHelper->processResponse($books);
    }

    public function getBook($bookId)
    {
        $book = Book::where('id', $bookId)->with(['authors', 'comments', 'characters'])->first();

        if ($book) {
            return $this->responseHelper->processResponse($book);
        } else {
            return $this->responseHelper->processResponse($book, 'not Found', true, 404);
        }
    }

    public function getCharacters(Request $request, $bookId)
    {
        $orderBy = $request->input('orderBy', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter');

        if ($filter) {
            $characters = Character::whereHas('books', function ($q) use ($bookId) {
                return $q->where('books.id', $bookId);
            })->where('gender', $filter)->orderBy($orderBy, $order)->get();
        } else {
            $characters = Character::whereHas('books', function ($q) use ($bookId) {
                return $q->where('books.id', $bookId);
            })->orderBy($orderBy, $order)->get();
        }
        if ($characters) {
            return $this->responseHelper->processResponse($characters);
        } else {
            return $this->responseHelper->processResponse($characters, 'not Found', true, 404);
        }
    }

    public function getComments($bookId)
    {
        $comments = Comment::where('book_id', $bookId)->orderBy('id', 'desc')->get();

        return $this->responseHelper->processResponse($comments);
    }

    public function addComment(Request $request, $bookId)
    {
        $ip = $request->ip();

        $comment = Comment::create([
            'book_id' => $bookId,
            'name' => $request->input('name','Anonymous'),
            'comment' => $request->input('comment'),
            'commenter_ip' => $ip
        ]);

        if ($comment) {
            return $this->responseHelper->processResponse($comment, 'Comment Added', false, 201);
        } else {
            return $this->responseHelper->processResponse($comment, 'An error occured', true, 500);
        }
    }

    public function preloadBooks(Request $request, BookPreload $preload)
    {
        $numberOfBooks = $request->input('number', 10);

        $preload->loadBooks($numberOfBooks);
        return response()->json(['error' => false, 'message' => 'Completed']);
    }

}
