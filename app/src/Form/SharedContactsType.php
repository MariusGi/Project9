<?php

namespace App\Form;

use App\Entity\SharedContacts;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SharedContactsType extends AbstractType
{
    private $contactRepository;
    private $userRepository;

    public function __construct(ContactRepository $contactRepository, UserRepository $userRepository)
    {
        $this->contactRepository = $contactRepository;
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact_id', ChoiceType::class, [
                'choices' => $this->getCurrentUserSavedNameIdArr($options['user_id_shared_by'])
            ])
            ->add('user_id_shared_to', ChoiceType::class, [
                'choices' => $this->getAvailableUsersToShareContact($options['user_id_shared_by'])
            ])
            ->add('user_id_shared_by', HiddenType::class, [
                'data' => $options['user_id_shared_by'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SharedContacts::class,
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

        if (empty($savedUsersArr)) {
            $savedUsersArr['0|No saved contacts to share'] = 0;
        }

        return $savedUsersArr;
    }

    private function getAvailableUsersToShareContact($userIdsToExcludeArr)
    {
        $availableContactsToShareArr = [];

        $availableContactsToShareData = $this->userRepository->findAllExcludingIds([
            $userIdsToExcludeArr
        ]);

        foreach ($availableContactsToShareData as $availableContactToShareData) {
            $id = $availableContactToShareData->getId();
            $email = $availableContactToShareData->getEmail();
            $contactEmailDisplayed = $id . '|' . $email;
            $availableContactsToShareArr[$contactEmailDisplayed] = $id;
        }

        if (empty($availableContactsToShareArr)) {
            $availableContactsToShareArr['0|No contacts to share to'] = 0;
        }

        return $availableContactsToShareArr;
    }
}
