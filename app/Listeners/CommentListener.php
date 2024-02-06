<?php

namespace App\Listeners;

use App\Events\CommentAdded;

class CommentListener
{
    public function handle(CommentAdded $event)
    {
        $comment = $event->getComment();

        // Your logic here, for example, updating the database or performing other actions
        // You can also dispatch additional jobs or events as needed

        // For demonstration purposes, let's just log the comment body
        \Log::info("New comment added: {$comment}");
    }

}
