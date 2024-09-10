<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        
        return view('books.index', compact('books'));
    }
    public function create()
    {
        return view('books.create');
    }
    public function store(Request $request)
    {
		// Code #1 (see explanation below) -----------------------------------------------------------------------------------------
        /*$request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'nullable',
        ]);
        
        $data = $request->except('_token'); // Exclure le champ _token
        Book::create($request->all());
        
        return redirect()->route('books.index')->with('success', 'Book created successfully.');*/
        
		// Code #2 (see explanation below) -----------------------------------------------------------------------------------------
	    $validatedData = $request->validate([
	        'title' => 'required',
	        'author' => 'required',
	        'description' => 'nullable',
	    ]);

	    Book::create($validatedData);

	    return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'nullable',
        ]);
        
        $book->update($request->all());
        
        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }
    public function destroy(Book $book)
    {
        $book->delete();
        
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}

/* 
Code #1 : Utilisation de $request->all() avec except()

Validation des données : Les données de la requête sont validées pour s'assurer que title et author sont présents,
et que description est optionnel.

Exclusion de _token : La méthode $request->except('_token') est utilisée pour exclure le champ _token des données de la requête. 
Cependant, cette variable $data n'est pas utilisée dans le Book::create() qui suit.
Création de l'enregistrement : La méthode Book::create($request->all()) est appelée pour créer un nouvel enregistrement dans la base de données. 
all() récupère toutes les données de la requête, y compris _token, ce qui n'est pas nécessaire ni conseillé.
Problème potentiel : Comme $request->all() inclut tous les champs de la requête, il inclura également des champs non désirés comme _token, 
qui ne sont pas des colonnes valides dans la base de données. 
Cela peut entraîner des erreurs ou des comportements inattendus si la base de données rejette ces colonnes non valides.

Code #2 : Utilisation de $validatedData

Validation des données : Comme dans le premier code, les données sont validées selon les règles définies.
Utilisation de $validatedData : Les données validées sont stockées dans $validatedData, 
qui contient uniquement les champs validés (title, author, description).
Création de l'enregistrement : La méthode Book::create($validatedData) est ensuite utilisée pour créer un enregistrement 
en utilisant uniquement les données validées.

Avantage : En utilisant $validatedData, vous vous assurez que seules les données validées sont passées au modèle Book. 
		   Cela empêche l'inclusion de champs indésirables comme _token et garantit que les seules colonnes qui seront insérées 
		   dans la base de données sont celles définies dans les règles de validation.

Conclusion :

Code 1:	utilise $request->all(), qui peut inclure des champs non souhaités comme _token, 
		ce qui n'est pas idéal et peut provoquer des erreurs si ces champs ne correspondent pas à des colonnes de la base de données.
Code 2:	est plus sécurisé et plus propre, car il n'utilise que les données validées, évitant ainsi tout problème potentiel lié à l'insertion de champs indésirables.

Dans la pratique, Code 2 est recommandé pour s'assurer que seules les données nécessaires et validées sont insérées dans la base de données.

*/
