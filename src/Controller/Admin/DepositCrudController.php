<?php

namespace App\Controller\Admin;

use App\Entity\Deposit;
use App\Service\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class DepositCrudController extends AbstractCrudController
{
    private $acc;
    private $requestStack;
    private $entityManager;
    private $pdfService;
    public function __construct(AccountRepository $acc, RequestStack $requestStack, EntityManagerInterface $entityManager, PdfService $pdfService){
        $this->acc = $acc;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->pdfService = $pdfService;
    }
    public static function getEntityFqcn(): string
    {
        return Deposit::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setSearchFields(['amount', 'payment_method','remarks', 'account.firstname']); // Specify searchable fields
    }
    
    public function configureFields(string $pageName): iterable
    {
        $account = $this->acc->findAll();
        $accountsId = [];
        $request = $this->requestStack->getCurrentRequest();
        // $orderId = $request->query->get('entityId');
        // $deposit = $orderId ? $this->entityManager->getRepository(Deposit::class)->find($orderId) : null;
        // // dd($deposit->getAccount());
        // $account_id = $deposit?$deposit->getAccountId():0;
        // if($account){
        //     foreach($account as $key){
        //         $accountsId[$key->getFirstname().' '.$key->getLastname()] = $key->getId();
        //     }
        // }
        
        yield Field::new('id')->hideOnForm();
        yield Field::new('amount');
        // yield ChoiceField::new('accountId')->setChoices($accountsId)->setRequired(true)->setFormTypeOption('data', $account_id);
        yield AssociationField::new('account') // Association field to link the Account
                ->setCrudController(AccountCrudController::class)
                ->setLabel('Account');
        yield ChoiceField::new('payment_method')->setChoices([
            "Bank or checkque"=>"Bank or checkque",
            "Mobile Banking"=>"Mobile Banking",
            "Cash"=>"Cash",
        ]);
        yield ImageField::new('receipt')->setUploadedFileNamePattern('[year]-[month]-[day]-[uuid]-[contenthash].[extension]')->setBasePath('uploads/images/receipts')->setUploadDir('public/uploads/images/receipts');

        yield Field::new('remarks');
        
    }

    public function configureActions(Actions $actions): Actions
    {
        $downloadPdf = Action::new('downloadPdf', 'Download PDF')
            ->linkToRoute('admin_deposit_download_pdf', function (Deposit $entity): array {
                return [
                    'id' => $entity->getId(),
                ];
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $downloadPdf)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_DETAIL, $downloadPdf);
    }

    /**
     * @Route("/admin/deposit/{id}/download-pdf", name="admin_deposit_download_pdf")
     */
    public function downloadPdfAction(EntityManagerInterface $entityManager, $id): Response
    {
        $entity = $entityManager->getRepository(Deposit::class)->find($id);
        // dd($entity);
        $pdfContent = $this->pdfService->generatePdf('pdf/pdf_deposit.html.twig', [
            'entity' => $entity,
        ]);

        $response = new StreamedResponse(function() use ($pdfContent) {
            echo $pdfContent;
        });

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="pdf_deposit.pdf"');

        return $response;
    }
    
}
