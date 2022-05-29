<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * @about Найти автора статьи по id статьи
     * @param Request $request
     * @return JsonResponse
     */
    public function getArticleAuthor(Request $request): JsonResponse
    {
        $articleId = $request->request->get('article_id');
        $article = Article::find($articleId);

        if ($article) {
            $author = $article->user;
            return response()->json($author);
        }

        return response()->json([
            'error' => 1,
            'message' => 'Artticle not found'
        ]);
    }

    /**
     * @about Изменение автора статьи
     * @param Request $request
     * @return JsonResponse
     */
    public function changeArticleAuthor(Request $request): JsonResponse
    {
        $articleId = $request->request->get('article_id');
        $newAutorId = $request->request->get('user_id');

        $article = Article::find($articleId);
        $newAutor = User::find($newAutorId);

        if (!$article) {
            return response()->json([
                'error' => 1,
                'message' => 'Artticle not found'
            ]);
        }

        if (!$newAutor) {
            return response()->json([
                'error' => 1,
                'message' => 'User not found'
            ]);
        }

        $article->user_id = $newAutorId;
        $article->save();
        return response()->json($article);
    }

}
