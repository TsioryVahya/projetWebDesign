<?php

namespace Config;

/**
 * Paths
 *
 * This file contains the path settings to find the main
 * directories of your application.
 *
 * If you need to change any of these, just edit this file.
 */
class Paths
{
    /**
     * The path to the system directory.
     *
     * @var string
     */
    public $systemDirectory = __DIR__ . '/../../vendor/codeigniter4/framework/system';

    /**
     * The path to the main application directory.
     *
     * @var string
     */
    public $appDirectory = __DIR__ . '/..';

    /**
     * The path to the writable directory.
     *
     * @var string
     */
    public $writableDirectory = __DIR__ . '/../../writable';

    /**
     * The path to the tests directory.
     *
     * @var string
     */
    public $testsDirectory = __DIR__ . '/../../tests';

    /**
     * The path to the view directory.
     *
     * @var string
     */
    public $viewDirectory = __DIR__ . '/../Views';
}
