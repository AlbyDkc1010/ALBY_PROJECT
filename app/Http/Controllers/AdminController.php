<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PDF;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('home', compact('user'));
    }
    public function books(){
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
     }
     public function submit_book(Request $req)
     {
        $validate = $req->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required',
            'tahun' => 'required',
            'penerbit' => 'required',
        ]);

        $book = new Book;
        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover')) {
            $extention = $req->file('cover')->extension();

            $filename = 'cover_buku_'.time().'.'.$extention;

            $req->file('cover')->storeAs(
                'public/cover_buku', $filename
            );
            $book->cover = $filename;
        }
        $book->save();

        $notification = array(
            'message' => 'Data buku berhasiil ditambahkan','alert-type' => 'success'
        );

        return redirect()->route('admin.book')->with($notification);
     }
        // AJAX PROCESS
        public function getDataBuku($id)
        {
                $buku = Book::find($id);
                return response()->json($buku);
        }

        public function update_book(Request $req)
            {
                $book = Book::find($req->get('id'));
                $validate = $req->validate([
                'judul' => 'required|max:255',
                'penulis' => 'required',
                'tahun' => 'required',
                'penerbit' => 'required',
                ]);
                $book->judul = $req->get('judul');
                $book->penulis = $req->get('penulis');
                $book->tahun = $req->get('tahun');
                $book->penerbit = $req->get('penerbit');
                if ($req->hasFile('cover')) {
                $extension = $req->file('cover')->extension();
                $filename = 'cover_buku_'.time().'.'.$extension;
                $req->file('cover')->storeAs(
                'public/cover_buku', $filename
                );
                Storage::delete('public/cover_buku/'.$req->get('old_cover'));
                $book->cover = $filename;
                }
                $book->save();
                $notification = array(
                'message' => 'Data buku berhasil diubah',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.books')->with($notification);
            }
        public function print_books()
        {
            $books = Book::all();
            $pdf = PDF::loadview('print_books',['books'=> $books]);
              return $pdf->download('data_buku.pdf');
        }
}