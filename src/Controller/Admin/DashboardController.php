<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Administrator;
use App\Entity\Account;
use App\Entity\Deposit;
use App\Entity\Income;
use App\Entity\Expense;
use App\Entity\Investment;
use App\Entity\Agenda;
use EasyCorp\Bundle\EasyAdminBundle\Config\Locale;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractDashboardController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Calculate start and end of last month
        $startOfLastMonth = (new \DateTime('first day of last month'))->setTime(0, 0);
        $endOfLastMonth = (new \DateTime('last day of last month'))->setTime(23, 59, 59);

        // Get the connection
        $connection = $this->entityManager->getConnection();

        // Raw SQL query
        $totalDepositSql = 'SELECT SUM(amount) as totalAmount FROM deposit';
        $totalIncomeSql = 'SELECT SUM(amount) as totalAmount FROM income';
        $totalExpenseSql = 'SELECT SUM(amount) as totalAmount FROM expense';
        $totalInvestmentSql = 'SELECT SUM(amount) as totalAmount FROM investment';
        //for last month
        $lastMonthTotalDepositSql = 'SELECT SUM(amount) as totalAmount FROM deposit WHERE created_at BETWEEN :start AND :end';
        $lastMonthTotalIncomeSql = 'SELECT SUM(amount) as totalAmount FROM income WHERE created_at BETWEEN :start AND :end';
        $lastMonthTotalExpenseSql = 'SELECT SUM(amount) as totalAmount FROM expense WHERE created_at BETWEEN :start AND :end';
        $lastMonthTotalInvestmentSql = 'SELECT SUM(amount) as totalAmount FROM investment WHERE created_at BETWEEN :start AND :end';


        // Execute query
        $stmtDep = $connection->prepare($totalDepositSql);
        $stmtInc = $connection->prepare($totalIncomeSql);
        $stmtExp = $connection->prepare($totalExpenseSql);
        $stmtInv = $connection->prepare($totalInvestmentSql);
        
        $stmtlastDep = $connection->prepare($lastMonthTotalDepositSql);
        $stmtlastDep->bindValue('start', $startOfLastMonth->format('Y-m-d H:i:s'));
        $stmtlastDep->bindValue('end', $endOfLastMonth->format('Y-m-d H:i:s'));

        $stmtlastInc = $connection->prepare($lastMonthTotalIncomeSql);
        $stmtlastInc->bindValue('start', $startOfLastMonth->format('Y-m-d H:i:s'));
        $stmtlastInc->bindValue('end', $endOfLastMonth->format('Y-m-d H:i:s'));

        $stmtlastExp = $connection->prepare($lastMonthTotalExpenseSql);
        $stmtlastExp->bindValue('start', $startOfLastMonth->format('Y-m-d H:i:s'));
        $stmtlastExp->bindValue('end', $endOfLastMonth->format('Y-m-d H:i:s'));

        $stmtlastInv = $connection->prepare($lastMonthTotalInvestmentSql);
        $stmtlastInv->bindValue('start', $startOfLastMonth->format('Y-m-d H:i:s'));
        $stmtlastInv->bindValue('end', $endOfLastMonth->format('Y-m-d H:i:s'));

        $resultstmtDep = $stmtDep->executeQuery()->fetchOne();
        $resultstmtInc = $stmtInc->executeQuery()->fetchOne();
        $resultstmtExp = $stmtExp->executeQuery()->fetchOne();
        $resultstmtInv = $stmtInv->executeQuery()->fetchOne();


        $lastMonthresultstmtDep = $stmtlastDep->executeQuery()->fetchOne();
        $lastMonthresultstmtInc = $stmtlastInc->executeQuery()->fetchOne();
        $lastMonthresultstmtExp = $stmtlastExp->executeQuery()->fetchOne();
        $lastMonthresultstmtInv = $stmtlastInv->executeQuery()->fetchOne();

        $actualBalance = $resultstmtDep+$resultstmtInc-$resultstmtExp-$resultstmtInv;
        // dd($resultstmtDep);
        return $this->render('admin/index.html.twig',[
            "resultstmtDep"=>number_format($resultstmtDep,2),
            "resultstmtInc"=>number_format($resultstmtInc,2),
            "resultstmtExp"=>number_format($resultstmtExp,2),
            "resultstmtInv"=>number_format($resultstmtInv,2),
            "lastMonthresultstmtDep"=>number_format($lastMonthresultstmtDep,2),
            "lastMonthresultstmtInc"=>number_format($lastMonthresultstmtInc,2),
            "lastMonthresultstmtExp"=>number_format($lastMonthresultstmtExp,2),
            "lastMonthresultstmtInv"=>number_format($lastMonthresultstmtInv,2),
            "actualBalance"=>number_format($actualBalance,2),
        ]);
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Al-Maaref private limited')
            ->setTranslationDomain('admin')
            ->setLocales(['ja', 'en']); // サポートするロケールを指定
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('administrator', 'fas fa-list', Administrator::class);
        yield MenuItem::linkToCrud('account', 'fas fa-users', Account::class);
        yield MenuItem::linkToCrud('deposit', 'fas fa-cloud', Deposit::class);
        yield MenuItem::linkToCrud('income', 'fas fa-receipt', Income::class);
        yield MenuItem::linkToCrud('expense', 'fas fa-square-minus', Expense::class);
        yield MenuItem::linkToCrud('investment', 'fas fa-globe', Investment::class);
        yield MenuItem::linkToCrud('agenda', 'fas fa-list', Agenda::class);
    }
}
