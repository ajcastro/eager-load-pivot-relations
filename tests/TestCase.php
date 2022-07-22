<?php

namespace AjCastro\EagerLoadPivotRelations\Tests;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
    }

    protected function getEnvironmentSetUp($app)
    {
        ( new \CreateUsersTable )->up();
        ( new \CreatePasswordResetsTable )->up();
        ( new \CreateBrandsTable )->up();
        ( new \CreateCarsTable )->up();
        ( new \CreateColorsTable )->up();
        ( new \CreateCarUserTable )->up();
        ( new \CreateTiresTable )->up();
    }
}