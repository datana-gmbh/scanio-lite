<?php

declare(strict_types=1);

namespace App\Controller;

use App\Crud\Domain\Enum\SortDirection;
use App\Crud\Domain\Value\Pagination;
use App\Crud\Domain\Value\Sorting;
use App\Crud\List\Query\QueryFactoryInterface;
use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::LIST, path: '/list/{venture}/{type}')]
final readonly class ListController
{
    public function __construct(
        private QueryFactoryInterface $queryFactory,
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request, Venture $venture, Type $type): Response
    {
        $query = $this->queryFactory->create($venture, $type);

        $pagination = new Pagination(
            $request->query->getInt('page', 1),
            $query->count(),
        );

        $sortings = array_map(
            static fn (string $property, string $value): Sorting => new Sorting($property, SortDirection::from($value)),
            array_keys($request->query->all('order')),
            array_values($request->query->all('order')),
        );

        return $this->responder->render('default/list.html.twig', [
            'venture' => $venture,
            'type' => $type,
            'result' => $query->execute($pagination, $sortings),
            'pagination' => $pagination,
            'sortings' => $sortings,
        ]);
    }
}
