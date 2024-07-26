# Usage

## BinCheckService

```php
$adapter = new App\Services\Adapters\BinCheckAdapter();
$service = new App\Services\BinCheckService($adapter);
$data = $service->getBinInfo('371775');
$service->response($data);
```

## BinCodes

```php
$adapter = new App\Services\Adapters\BinCodesAdapter();
$service = new App\Services\BinCodesService($adapter);
$data = $service->getBinInfo('371775');
$service->response($data);
```

## BinList

```php
$adapter = new App\Services\Adapters\BinListAdapter();
$service = new App\Services\BinListService($adapter);
$data = $service->getBinInfo('371775');
$service->response($data);
```

## GreipService

```php
$adapter = new App\Services\Adapters\GreipAdapter();
$service = new App\Services\GreipService($adapter);
$data = $service->getBinInfo('371775');
$service->response($data);
```

## IinBinService

```php
$adapter = new App\Services\Adapters\IinBinAdapter();
$service = new App\Services\IinBinService($adapter);
$data = $service->getBinInfo('371775');
$service->response($data);
```

## MultiBinService

```php
$multiBinService = new MultiBinService([
    'bincodes' => new BinCodesService(new BinCodesAdapter()),
    'bincheck' => new BinCheckService(new BinCheckAdapter()),
    'binlist' => new BinListService(new BinListAdapter()),
    'greip' => new GreipService(new GreipAdapter()),
    'iinlist' => new IinListService(new IinListAdapter()),
]);

$multiBinService->getBinInfo('371775');
```
