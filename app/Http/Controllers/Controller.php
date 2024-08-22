<?php

namespace App\Http\Controllers;

/**
 * @OA\Info (
 *     version = "1.0.0",
 *     title = "Homework",
 *     description ="文章編輯 API",
 *     @OA\Contact(
 *         email="vincent.kh.gy@gamil.com"
 *     )
 * )
 * @OA\PathItem (
 *     path = "/"
 * )
 ** @OA\Server(
 *     url = "http://127.0.0.1:8000/api/",
 *     description="LocalHost"
 * )
 * @OA\Components(
 *     @OA\Response(
 *         response="200",
 *         description="成功",
 *          @OA\JsonContent(
 *              example={
 *                  "msg": "success"
 *              }
 *          )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="伺服器發生錯誤",
 *         @OA\JsonContent(
 *             example={
 *                 "msg": "error Message."
 *             }
 *         )
 *     )
 * )
 */
abstract class Controller
{
    //
}
