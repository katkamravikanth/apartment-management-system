<?php

namespace App\DataFixtures;

use App\Entity\UserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $userTypes = [
            [
                "Super Admin",
                ""
            ],
            [
                "President / Chairperson",
                "The President or Chairperson is the leader of the committee and is responsible for overseeing all community operations. This role involves setting the agenda for meetings, leading discussions, and ensuring that decisions are implemented. The President acts as the main point of contact between the committee and the residents."
            ],
            [
                "Vice President / Vice Chairperson",
                "The Vice President or Vice Chairperson assists the President and steps in to fulfill the President's duties in their absence. This role often involves managing specific projects or committees within the community and providing support in decision-making processes."
            ],
            [
                "Secretary",
                "The Secretary is responsible for maintaining all official records of the committee, including meeting minutes, correspondence, and other documentation. The Secretary ensures that records are accurate and accessible to the community members and helps organize meetings."
            ],
            [
                "Treasurer",
                "The Treasurer manages the financial affairs of the community, including budgeting, collecting fees, paying bills, and maintaining financial records. This role involves preparing financial reports, ensuring compliance with financial regulations, and advising the committee on financial matters."
            ],
            [
                "Operations Manager / Facilities Manager",
                "The Operations or Facilities Manager oversees the day-to-day maintenance and operations of the community's common areas, amenities, and infrastructure. This role involves coordinating with service providers, scheduling repairs, and ensuring that the facilities are well-maintained."
            ],
            [
                "Security Officer / Security Manager",
                "The Security Officer or Manager is responsible for the safety and security of the community. This role includes coordinating security staff, managing access control, monitoring surveillance systems, and addressing any security concerns that arise."
            ],
            [
                "Maintenance Coordinator",
                "The Maintenance Coordinator is responsible for organizing and supervising the maintenance of the community’s physical assets, including landscaping, buildings, and roads. This role involves working with contractors, scheduling routine maintenance, and addressing repair needs."
            ],
            [
                "Events Coordinator / Social Chairperson",
                "The Events Coordinator or Social Chairperson organizes and oversees social events, activities, and programs within the community. This role involves planning events, managing budgets, promoting community involvement, and ensuring that events run smoothly."
            ],
            [
                "Landscape Coordinator",
                "The Landscape Coordinator oversees the landscaping of the community, including the maintenance of gardens, lawns, trees, and other green spaces. This role involves working with landscapers, planning seasonal plantings, and ensuring the aesthetic appeal of the community."
            ],
            [
                "Communications Director",
                "The Communications Director manages the communication channels within the community, such as newsletters, websites, social media, and bulletin boards. This role involves keeping residents informed about community news, events, and important announcements."
            ],
            [
                "Architectural Review Committee Chairperson",
                "The Architectural Review Committee (ARC) Chairperson leads the committee responsible for reviewing and approving architectural changes or improvements made by residents. This role ensures that any modifications comply with community guidelines and maintain the aesthetic integrity of the community."
            ],
            [
                "Rules and Regulations Chairperson",
                "The Rules and Regulations Chairperson oversees the creation, implementation, and enforcement of community rules. This role involves ensuring that residents comply with community standards and addressing any violations or disputes that arise."
            ],
            [
                "Finance Committee Chairperson",
                "The Finance Committee Chairperson leads the committee responsible for overseeing the financial health of the community. This role involves budgeting, financial planning, and advising on major financial decisions, such as investments or special assessments."
            ],
            [
                "Community Relations Officer",
                "The Community Relations Officer acts as a liaison between the committee and the residents. This role involves addressing resident concerns, fostering a sense of community, and promoting positive interactions between neighbors and the committee."
            ]
        ];

        foreach ($userTypes as $key => $userType) {
            $user = new UserType();
            $user->setName($userType[0]);
            $user->setDescription($userType[1]);

            $manager->persist($user);

            $this->addReference("userType{$key}", $user);
        }

        $manager->flush();
    }
}