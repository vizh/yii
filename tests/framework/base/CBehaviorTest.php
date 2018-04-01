<?php
require_once __DIR__.'/NewComponent.php';
require_once __DIR__.'/NewBehavior.php';

require_once __DIR__.'/NewBeforeValidateBehavior.php';
require_once __DIR__.'/NewFormModel.php';

require_once __DIR__.'/BehaviorTestController.php';
require_once __DIR__.'/TestBehavior.php';

class CBehaviorTest extends CTestCase
{
    public function testAttachBehavior()
    {
        $component = new NewComponent();
        $component->attachBehavior('a', new NewBehavior);
        $this->assertFalse($component->behaviorCalled);
        $this->assertFalse(method_exists($component, 'test'));
        $this->assertEquals(2, $component->test());
        $this->assertTrue($component->behaviorCalled);
        $this->expectException(CException::class);
        /** @noinspection PhpUndefinedMethodInspection */
        $component->test2();
    }

    public function testDisableBehaviors()
    {
        $component = new NewComponent;
        $component->attachBehavior('a', new NewBehavior);
        $component->disableBehaviors();
        $this->expectException(CException::class);
        // test should not be called since behavior is disabled
        /** @noinspection PhpUndefinedMethodInspection */
        echo $component->test();
    }

    /**
     * Since disableBehaviors() was called, validate() should not call beforeValidate() from behavior.
     *
     * @return void
     */
    public function testDisableBehaviorsAndModels()
    {
        $model = new NewFormModel();
        $model->disableBehaviors();
        $this->assertTrue($model->validate());
    }

    /**
     * enableBehaviors() should work after disableBehaviors().
     *
     * @return void
     */
    public function testDisableAndEnableBehaviorsAndModels()
    {
        $this->expectException('NewBeforeValidateBehaviorException');
        $model = new NewFormModel();
        $model->disableBehaviors();
        $model->enableBehaviors();
        $model->validate();
    }

    /**
     * https://github.com/yiisoft/yii/issues/162
     */
    public function testDuplicateEventHandlers()
    {
        $controller = new BehaviorTestController('behaviorTest');

        $b = new TestBehavior();
        $this->assertFalse($b->enabled);

        $b->attach($controller);
        $this->assertTrue($b->enabled);

        $b->setEnabled(true);
        $this->assertTrue($b->enabled);

        $controller->onTestEvent();
        $this->assertEquals(1, $controller->behaviorEventHandled);

        $b->setEnabled(false);
        $this->assertFalse($b->enabled);
        $controller->onTestEvent();
        $this->assertEquals(1, $controller->behaviorEventHandled);

        $b->setEnabled(true);
        $this->assertTrue($b->enabled);
        $controller->onTestEvent();
        $this->assertEquals(2, $controller->behaviorEventHandled);

        $b->detach($controller);
        $this->assertFalse($b->enabled);
        $controller->onTestEvent();
        $this->assertEquals(2, $controller->behaviorEventHandled);

        $b->setEnabled(true);
        $this->assertTrue($b->enabled);
        $controller->onTestEvent();
        $this->assertEquals(2, $controller->behaviorEventHandled);
    }
}

