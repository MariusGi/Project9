<?php

namespace App\Form;

use App\Entity\SharedContacts;
use App\Repository\ContactRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SharedContactsType extends AbstractType
{
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact_id', ChoiceType::class, [
                'choices' => $this->getCurrentUserSavedNameIdArr($options['user_id_shared_by'])
            ])
            ->add('user_id_shared_to')
            ->add('user_id_shared_by')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SharedContacts::class,
            'user_id_shared_to' => 0,
            'user_id_shared_by' => 0,
        ]);
    }

    private function getCurrentUserSavedNameIdArr($userId)
    {
        $savedUsersArr = [];

        $userContactsData = $this->contactRepository->findBy([
            'user_id_saved_to' => $userId,
        ]);

        foreach ($userContactsData as $userContactData) {
            $id = $userContactData->getId();
            $name = $userContactData->getName();
            $contactNameDisplayed = $id . '|' . $name;
            $savedUsersArr[$contactNameDisplayed] = $id;
        }

        return $savedUsersArr;
    }
}
