<?php namespace Lio\Forum\Replies\Handlers;

use Lio\Core\Handler;
use Lio\Forum\Forum;
use Lio\Forum\EloquentReplyRepository;
use Mitch\EventDispatcher\Dispatcher;

class DeleteReplyHandler implements Handler
{
    private $forum;
    private $repository;
    private $dispatcher;

    public function __construct(Forum $forum, EloquentReplyRepository $repository, Dispatcher $dispatcher)
    {
        $this->forum = $forum;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $reply = $this->forum->deleteThreadReply($command->reply);
        $this->repository->delete($reply);
        $this->dispatcher->dispatch($this->forum->releaseEvents());
        return $reply;
    }
}
