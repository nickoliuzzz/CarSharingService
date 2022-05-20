<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Entity\Friend;
use App\Service\XlsExporter;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class FriendCrudController extends AbstractCrudController
{
    public const DOWNLOAD_REPORT_ROUTE = 'download_report';

    public static function getEntityFqcn(): string
    {
        return Friend::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('userName'),
            NumberField::new('kilometrage'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /** @var QueryBuilder $qb */
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $qb->andWhere('entity.user = :currentUser');
        $qb->setParameter('currentUser', $this->getCurrentUser());

        return $qb;
    }


    public function createEntity(string $entityFqcn)
    {
        return new Friend($this->getCurrentUser());
    }

    private function getCurrentUser(): User
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Current user must be type of '. User::class);
        }

        return $user;
    }

    #[Route(DashboardController::PROFILE_PREFIX.'/download-report', name: self::DOWNLOAD_REPORT_ROUTE)]
    public function downloadXls(#[CurrentUser] User $user, XlsExporter $xlsExporter): Response
    {
        ob_start();
        $xlsExporter->exportFriendsKilometrages($user)->save('php://output');
        return new Response(
            ob_get_clean(),  // read from output buffer
            200,
            array(
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="doc.xlsx"',
            )
        );
    }
}
