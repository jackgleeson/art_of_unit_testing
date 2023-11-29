<?php

use ArtOfUnitTesting\isolationFrameworks\IView;
use ArtOfUnitTesting\isolationFrameworks\Presenter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EventRelatedTest extends TestCase
{
    #[Test]
    public function ctor_WhenViewIsLoaded_CallsViewRender() : void
    {
        $mockView = $this->createMock(IView::class);
        // stub out the attaching of the Event Listener callback
        $mockView->method('loaded')
            ->willReturnCallback(function () use ($mockView) {
                $mockView->render("Hello, World!");
            });

        // confirm the callback is called.
        $mockView->expects($this->once())
            ->method('render')
            ->with("Hello, World!");

        // the Presenter constructor will fire the loaded() event
        // and should return and simultaneously trigger the stubbed
        // event listener(Which simulates Presenter::onLoaded())
        // which will then finally call render(). Yuck!
        $presenter = new Presenter($mockView);

    }

}
