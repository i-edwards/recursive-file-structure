<?php

declare(strict_types=1);

class LoaderTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function parse(): void
    {
        $loader = new \app\Loader();
        $file = new \SplFileObject(__DIR__ . '/../files.txt');

        $result = $loader->parse($file);
        
        $expected = [
            'C:\\' => [
                'Documents' => [
                    'Images' => [
                        'Image1.jpg',
                        'Image2.jpg',
                        'Image3.png',
                    ],
                    'Works' => [
                        'Letter.doc',
                    ],
                    'Accountant' => [
                        'Accounting.xls',
                        'AnnualReport.xls',
                    ],
                ],
                'Program Files' => [
                    'Skype' => [
                        'Skype.exe',
                        'Readme.txt',
                    ],
                    'Mysql' => [
                        'Mysql.exe',
                        'Mysql.com',
                    ],
               ],
            ],
        ];

        $this->assertEquals($expected, $result);
    }
}
