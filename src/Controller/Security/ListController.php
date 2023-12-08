<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Crud\Domain\Enum\SortDirection;
use App\Crud\Domain\Value\Pagination;
use App\Crud\Domain\Value\Sorting;
use App\Crud\List\Query\QueryFactoryInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::LIST, path: '/list/{group}/{category}')]
final readonly class ListController
{
    public function __construct(
        private QueryFactoryInterface $queryFactory,
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request, Group $group, Category $category): Response
    {
        $query = $this->queryFactory->create($group, $category);

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
            'group' => $group,
            'category' => $category,
            'result' => $query->execute($pagination, $sortings),
            'pagination' => $pagination,
            'sortings' => $sortings,
        ]);
    }
}
