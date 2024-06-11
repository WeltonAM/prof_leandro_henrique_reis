<?php

use App\Domains\Budgets\Repositories\BudgetRepositoryMemory;
use App\Domains\Budgets\UseCases\Data\BudgetInputData;
use App\Domains\Budgets\UseCases\NewBudget;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

$inputData = [
    'number' => 1,
    'date' => Carbon::now(),
    'customer' => [
        'name' => 'John Doe',
        'address' => [
            'street' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
        ]
    ],
    'items' => [
        [
            'title' => 'Consultoria',
            'description' => 'Serviço de consultoria',
            'price' => 1000,
        ],
        [
            'title' => 'Desenvolvimento do Sistema de Orçamento',
            'description' => 'Orçamento terá X, Y e Z',
            'price' => 2000,
        ],
    ]
];

test("new budget", function () use ($inputData) {
    $data = BudgetInputData::build($inputData);
    $repository = new BudgetRepositoryMemory();

    $service = new NewBudget($data, $repository);

    $output = $service->handle();

    $budget = $repository->findById($output->id);

    expect(Uuid::isValid($budget['id']))->toBeTrue();
});
