<?php

namespace Tests;

use App\Models\Setting;
use App\Models\Category;
use App\Models\Company;
use App\Models\Department;
use App\Models\Manufacturer;
use App\Models\Depreciation;
use App\Models\AssetModel;
use App\Models\Statuslabel;
use App\Models\User;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Auth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use DatabaseTransactions;
    protected function _before()
    {
        Artisan::call('migrate');
        factory(Setting::class)->create();
    }

    protected function signIn($user = null)
    {
        if (!$user) {
            $user = factory(User::class)->states('superuser')->create([
                'location_id' => $this->createValidLocation()->id
            ]);
        }
        Auth::login($user);

        return $user;
    }

    protected function createValidAssetModel($state = 'mbp-13-model', $overrides = [])
    {
        return factory(AssetModel::class)->states($state)->create(array_merge([
            'category_id' => $this->createValidCategory(),
            'manufacturer_id' => $this->createValidManufacturer(),
            'depreciation_id' => $this->createValidDepreciation(),
        ],$overrides));
    }

    protected function createValidCategory($state = 'asset-laptop-category', $overrides = [])
    {
        return factory(Category::class)->states($state)->create($overrides);
    }

    protected function createValidCompany($overrides = [])
    {
        return factory(Company::class)->create($overrides);
    }


    protected function createValidDepartment($state = 'engineering', $overrides = [])
    {
        return factory(Department::class)->states($state)->create(array_merge([
            'location_id' => $this->createValidLocation()->id
        ], $overrides));
    }

    protected function createValidDepreciation($state = 'computer', $overrides = [])
    {
        return factory(Depreciation::class)->states($state)->create($overrides);
    }

    protected function createValidLocation($overrides = [])
    {
        return factory(Location::class)->create($overrides);
    }

    protected function createValidManufacturer($state = 'apple', $overrides = [])
    {
        return factory(Manufacturer::class)->states($state)->create($overrides);
    }

    protected function createValidSupplier($overrides = [])
    {
        return factory(Supplier::class)->create($overrides);
    }

    protected function createValidStatuslabel($state = 'rtd', $overrides= [])
    {
        return factory(Statuslabel::class)->states($state)->create($overrides);
    }

    protected function createValidUser($overrides= [])
    {
        return factory(User::class)->create(
            array_merge([
                'location_id'=>$this->createValidLocation()->id
            ], $overrides)
        );
    }

    protected function createValidAsset($overrides = [])
    {
        $locId = $this->createValidLocation()->id;
        $this->createValidAssetModel();
        return factory(Asset::class)->states('laptop-mbp')->create(
            array_merge([
                'rtd_location_id' => $locId,
                'location_id' => $locId,
                'supplier_id' => $this->createValidSupplier()->id
            ], $overrides)
        );
    }

}
