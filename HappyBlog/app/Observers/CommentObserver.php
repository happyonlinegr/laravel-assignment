<?php

namespace App\Observers;

use App\Mail\CommentEmail;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommentObserver
{
    public function created(Comment $comment): void
    {
           
        Mail::to('recipient@example.com')->send(new CommentEmail($comment));
      
    }
}
