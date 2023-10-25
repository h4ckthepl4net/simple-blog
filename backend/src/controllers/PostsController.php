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
            $response->code(\HTTPCodes::NOT_FOUND);
            $response->json([
                'error' => true,
                'message' => 'Post not found',
            ]);
        } else {
            $response->json($post[0]);
        }
    }

    public function createPost($request, $response) {
        $user = $this->authenticate();
        $constraints = [
            'title' => v::stringVal()->length(5, 255)->notEmpty()->notOptional()->setName('title'),
            'content' => v::stringVal()->length(30, 1000)->notEmpty()->notOptional()->setName('content'),
            'categories' => v::arrayVal()->length(0, 10)->each(
                v::stringVal()->length(1, 50)->notEmpty()->notOptional()->setName('category')
            ),
        ];
        $this->validatePostBody($constraints);
        $body = $request->paramsPost();
        $title = $body->get('title');
        $content = $body->get('content');
        $categories = $body->get('categories');
        $model = new \ReactBlog\Backend\Models\PostsModel();
        $postId = $model->createPost($user->id, $title, $content, $categories);
        $response->json([
            'error' => false,
            'message' => 'Post created',
            'postId' => $postId,
        ])->code(\HTTPCodes::CREATED)->send();
    }

    public function deletePost($request, $response) {
        $user = $this->authenticate();
        $constraints = [
            'postId' => v::intVal()->min(0)->notEmpty()->notOptional()->setName('postId'),
        ];
        $this->validateNamedParams($constraints);
        $postId = $request->paramsNamed()->get('postId');
        $model = new \ReactBlog\Backend\Models\PostsModel();
        $model->deletePost($postId, $user->id);
        $response->json([
            'error' => false,
            'message' => 'Post deleted',
        ])->code(\HTTPCodes::OK)->send();
    }

    public function editPost($request, $response) {
        $user = $this->authenticate();
        $postIdConstraint = [
            'postId' => v::intVal()->min(0)->notEmpty()->notOptional()->setName('postId'),
        ];
        $this->validateNamedParams($postIdConstraint);
        $constraints = [
            'title' => v::stringVal()->length(5, 255)->notEmpty()->notOptional()->setName('title'),
            'content' => v::stringVal()->length(30, 1000)->notEmpty()->notOptional()->setName('content'),
            'categories' => v::arrayVal()->length(0, 10)->each(
                v::stringVal()->length(1, 50)->notEmpty()->notOptional()->setName('category')
            ),
        ];
        $this->validatePostBody($constraints);
        $postId = $request->paramsNamed()->get('postId');
        $body = $request->paramsPost();
        $title = $body->get('title');
        $content = $body->get('content');
        $categories = $body->get('categories');
        $model = new \ReactBlog\Backend\Models\PostsModel();
        $newPostId = $model->editPost($postId, $user->id, $title, $content, $categories);
        $response->json([
            'error' => false,
            'message' => 'Post updated',
            'postId' => $newPostId,
        ])->code(\HTTPCodes::OK)->send();
    }
}