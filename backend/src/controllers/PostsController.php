<?php

namespace ReactBlog\Backend\Controllers;
use Respect\Validation\Validator as v;

class PostsController extends BaseController {
    public function getPosts($request, $response) {
        $constraints = [
            'page' => v::intVal()->min(1)->notEmpty()->notOptional()->setName('page'),
            'limit' => v::intVal()->min(1)->max(100)->notEmpty()->notOptional()->setName('limit'),
            'own' => v::boolVal(),
        ];
        $this->validateQuery($constraints);
        $queryParams = $request->paramsGet();
        $page = $queryParams->get('page');
        $limit = $queryParams->get('limit');
        $own = !!$queryParams->get('own');
        $tokenPayload = $this->authenticate($own);
        $model = new \ReactBlog\Backend\Models\PostsModel();
        $posts = $model->getPosts(intval($page), intval($limit), $own ? $tokenPayload->id : null);
        $response->json($posts);
    }

    public function getSpecificPost($request, $response) {
        $constraints = [
            'postId' => v::intVal()->min(0)->notEmpty()->notOptional()->setName('postId'),
        ];
        $this->validateNamedParams($constraints);
        $postId = $request->paramsNamed()->get('postId');
        $model = new \ReactBlog\Backend\Models\PostsModel();
        $post = $model->getPost($postId);
        if (!array_key_exists(0, $post)) { // TODO check this
            $response->code(404);
            $response->json([
                'error' => true,
                'message' => 'Post not found',
            ]);
        } else {
            $response->json($post[0]);
        }
    }
}