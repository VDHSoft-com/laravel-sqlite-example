<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeMessageController;
use App\Http\Controllers\Message1Controller;

use App\Http\Controllers\xxTestController;
use App\Http\Controllers\BookController; // sqlite

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('books', BookController::class);
//Route::get('books', [BookController::class, 'index']);

/*
La différence entre Route::get('books', [BookController::class, 'index']); et Route::resource('books', BookController::class); réside dans le nombre de routes que chacune de ces méthodes enregistre et leur fonction respective.

1. Route::get('books', [BookController::class, 'index']);
Cette ligne définit une seule route GET /books qui pointe uniquement vers la méthode index du BookController. Cela signifie que lorsque vous accédez à l'URL /books, Laravel exécutera la méthode index de votre contrôleur. Aucune autre route n'est définie, donc si vous essayez d'utiliser d'autres actions comme create, store, etc., elles ne seront pas disponibles.

2. Route::resource('books', BookController::class);
Cette méthode enregistre automatiquement un ensemble complet de routes pour un contrôleur de ressources, ce qui inclut plusieurs actions couramment utilisées dans une application CRUD (Create, Read, Update, Delete). En utilisant Route::resource, Laravel enregistre les routes suivantes :

GET /books - Appelle la méthode index (affiche la liste des livres).
GET /books/create - Appelle la méthode create (affiche le formulaire pour créer un nouveau livre).
POST /books - Appelle la méthode store (enregistre un nouveau livre dans la base de données).
GET /books/{book} - Appelle la méthode show (affiche un livre spécifique).
GET /books/{book}/edit - Appelle la méthode edit (affiche le formulaire pour modifier un livre).
PUT/PATCH /books/{book} - Appelle la méthode update (met à jour un livre spécifique).
DELETE /books/{book} - Appelle la méthode destroy (supprime un livre spécifique).
Pourquoi Route::resource fonctionne alors que Route::get ne fonctionne pas ?
Lorsque vous utilisez Route::get('books', [BookController::class, 'index']);, seule la route pour la méthode index est définie. Si dans vos vues ou votre code, vous utilisez des routes vers d'autres actions comme books.create, books.store, etc., Laravel ne pourra pas les trouver, d'où l'erreur "Route [books.create] not defined".

En revanche, Route::resource('books', BookController::class); enregistre automatiquement toutes les routes nécessaires pour un contrôleur de ressources, incluant books.create et les autres, ce qui fait que toutes les actions associées au contrôleur sont accessibles et définies.

Quand utiliser l'un ou l'autre ?
Route::get : Utilisez cette méthode lorsque vous voulez définir une route spécifique et unique pour une action précise. Par exemple, si vous n'avez besoin que de la liste des livres (méthode index), vous pouvez utiliser Route::get.

Route::resource : Utilisez cette méthode lorsque vous avez un contrôleur qui gère plusieurs actions pour un modèle (par exemple, toutes les actions CRUD pour un modèle Book). Cela vous évite de définir manuellement chaque route pour chaque action du contrôleur.

En résumé, Route::resource est plus pratique et automatique pour les contrôleurs qui suivent un schéma CRUD standard.
*/
