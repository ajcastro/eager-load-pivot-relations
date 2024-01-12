<?php

namespace AjCastro\EagerLoadPivotRelations\Tests;

use CreateBrandsTable;
use CreateCarsTable;
use CreateCarUserTable;
use CreateColorsTable;
use CreatePasswordResetsTable;
use CreateTiresTable;
use CreateUsersTable;
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
        (new CreateUsersTable())->up();
        (new CreatePasswordResetsTable())->up();
        (new CreateBrandsTable())->up();
        (new CreateCarsTable())->up();
        (new CreateColorsTable())->up();
        (new CreateCarUserTable())->up();
        (new CreateTiresTable())->up();
    }
}
