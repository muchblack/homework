<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsCollection;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\PostLang;

/**
 * @OA\Get(
 *     path="/posts",
 *     tags={"posts"},
 *     summary="取得文章列表",
 *     description="取得文章列表",
 *     @OA\Parameter(
 *         name="filter",
 *         description="作者查詢",
 *         required=false,
 *         in="query",
 *         @OA\Schema (
 *             type="string",
 *             example="vincent"
 *         )
 *     ),
 *     @Oa\Response(
 *         response=200,
 *         description="請求成功",
 *         @OA\JsonContent(
 *             example={
 *                 "data":{
 *                     "id":1,
 *                     "author":"vincent",
 *                     "status":"pub",
 *                     "postTitle":{
 *                         "ch":{
 *                             "postTitle":"測試1",
 *                         },
 *                         "en":{
 *                             "postTitle":"Test1",
 *                         },
 *                         "jp":{
 *                             "postTitle":"測試1",
 *                         }
 *                     },
 *                     "postContent":{
 *                         "ch":{
 *                              "postContent":"測試1",
 *                          },
 *                          "en":{
 *                              "postContent":"Test1",
 *                          },
 *                          "jp":{
 *                              "postContent":"測試1",
 *                          }
 *                     },
 *                     "created_at":"2024-08-22",
 *                     "updated_at":"2024-08-22",
 *                 }
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         ref="#/components/responses/500"
 *     )
 * ),
 * @OA\Post(
 *     path="/posts",
 *     tags={"posts"},
 *     summary="新增文章",
 *     description="新增文章",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required = {"author", "status", "postLangType", "postTitle", "postContent"},
 *             example={
 *                 "author": "vincent",
 *                 "status": "temp",
 *                 "postLangType": "ch",
 *                 "postTitle": "測試",
 *                 "postContent": "測試"
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         ref="#/components/responses/200"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         ref="#/components/responses/500"
 *     )
 * ),
 * @OA\Put(
 *     path="/posts/{postId}",
 *     tags={"posts"},
 *     summary="修改文章",
 *     description="修改文章",
 *     @OA\Parameter(
 *          name="postId",
 *          description="文章Id",
 *          required=true,
 *          in="path",
 *          @OA\Schema (
 *              type="string",
 *              example="1"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required = {"author", "status", "postLangType", "postTitle", "postContent"},
 *              example={
 *                  "author": "vincent",
 *                  "status": "temp",
 *                  "postLangType": "ch",
 *                  "postTitle": "測試",
 *                  "postContent": "測試"
 *              }
 *          )
 *      ),
 *     @OA\Response(
 *          response=200,
 *          ref="#/components/responses/200"
 *      ),
 *      @OA\Response(
 *          response=500,
 *          ref="#/components/responses/500"
 *      )
 * ),
 * @OA\Delete(
 *      path="/posts/{postId}",
 *      tags={"posts"},
 *      summary="刪除文章",
 *      description="刪除文章",
 *      @OA\Parameter(
 *           name="postId",
 *           description="文章Id",
 *           required=true,
 *           in="path",
 *           @OA\Schema (
 *               type="string",
 *               example="1"
 *           )
 *       ),
 *      @OA\Response(
 *           response=200,
 *           ref="#/components/responses/200"
 *       ),
 *       @OA\Response(
 *           response=500,
 *           ref="#/components/responses/500"
 *       )
 *  )
 */
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        //
        if($request->has('filter'))
        {
            $posts = Posts::where('author', $request->input('filter'))->get();
        }
        else
        {
            $posts = Posts::all();
        }

        if($posts->count() > 0)
        {
            return response()->json(data: new PostsCollection($posts));
        }

        return response()->json(data: new PostsCollection([]));
//        return response()->json(["data" => PostsCollection::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        //
        $params = $request->all();
        try{
            $posts = Posts::create([
                'author' => $params['author'],
                'status' => $params['status'],
            ]);

            PostLang::create([
                'postId' => $posts->id,
                'postLangType' => $params['postLangType'],
                'postTitle' => $params['postTitle'],
                'postContent' => $params['postContent'],
            ]);
        }
        catch(\Exception $e){
            return response()->json(['msg'=> $e->getMessage()],500);
        }

        return response()->json(['msg'=> 'Success.'],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): \Illuminate\Http\JsonResponse
    {
        //
        $params = $request->all();
        try{
            Posts::where('id', $id)->update([
                'author' => $params['author'],
                'status' => $params['status'],
            ]);

            if(PostLang::where('postId', $id)->where('postLangType', $params['postLangType'])->first())
            {
                PostLang::where('postId', $id)->where('postLangType',$params['postLangType'])->update([
                    'postTitle' => $params['postTitle'],
                    'postContent' => $params['postContent'],
                ]);
            }
            else
            {
                PostLang::create([
                    'postId' => $id,
                    'postLangType' => $params['postLangType'],
                    'postTitle' => $params['postTitle'],
                    'postContent' => $params['postContent'],
                ]);
            }
        }catch (\Exception $e){
            return response()->json(['msg'=> $e->getMessage()],500);
        }

        return response()->json(['msg'=> 'Success.'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        //
        try {
            Posts::where('id', $id)->delete();
            PostLang::where('postId', $id)->delete();
        }catch (\Exception $e){
            return response()->json(['msg'=> $e->getMessage()],500);
        }
        return response()->json(['msg'=> 'Success.'],200);
    }
}
