<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @about Создание статьи пользователем
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createArticle(Request $request): JsonResponse
    {
        $userId = $request->request->get('user_id');
        $title = $request->request->get('title');

        $user = User::find($userId);

        if ($user) {
            $article = Article::create([
                'title' => $title,
                'user_id' => $userId,
            ]);

            return response()->json($article);
        }

        return response()->json([
            'error' => 1,
            'message' => 'User not found'
        ]);
    }

    /**
     * @about Получение всех статей пользователя по user_id
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserArticles(Request $request): JsonResponse
    {
        $userId = $request->request->get('user_id');

        $user = User::find($userId);
        if ($user) {
            $articles = $user->articles;

            return response()->json($articles);
        }

        return response()->json([
            'error' => 1,
            'message' => 'User not found'
        ]);
    }

}
