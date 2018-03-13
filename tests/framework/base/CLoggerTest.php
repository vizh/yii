<?php

class CLoggerTest extends CTestCase
{
    public function testLogs()
    {
        $logger = new CLogger();

        $logs = [
            ['message1', 'debug', 'application.pages'],
            ['message2', 'info', 'application.config'],
            ['message3', 'info', 'application.pages'],
        ];

        foreach ($logs as $log) {
            $logger->log($log[0], $log[1], $log[2]);
        }

        $l = $logger->getLogs('debug');
        $this->assertSame($logs[0], array_slice($l[0], 0, 3));

        $l = $logger->getLogs('debug , Info');
        $this->assertSame($logs[0], array_slice($l[0], 0, 3));
        $this->assertSame($logs[1], array_slice($l[1], 0, 3));
        $this->assertSame($logs[2], array_slice($l[2], 0, 3));

        $l = $logger->getLogs('', 'application.config');
        $this->assertSame($logs[1], array_slice($l[0], 0, 3));

        $l = $logger->getLogs('', 'application.*');
        $this->assertSame($logs[0], array_slice($l[0], 0, 3));
        $this->assertSame($logs[1], array_slice($l[1], 0, 3));
        $this->assertSame($logs[2], array_slice($l[2], 0, 3));

        $l = $logger->getLogs('', 'application.config , Application.pages');
        $this->assertSame($logs[0], array_slice($l[0], 0, 3));
        $this->assertSame($logs[1], array_slice($l[1], 0, 3));
        $this->assertSame($logs[2], array_slice($l[2], 0, 3));

        $l = $logger->getLogs('info', 'application.config');
        $this->assertSame($logs[1], array_slice($l[0], 0, 3));

        $l = $logger->getLogs('info,debug', 'application.config');
        $this->assertSame($logs[1], array_slice($l[0], 0, 3));
    }
}
