<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250210055948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add category';
    }

    public function up(Schema $schema): void
    {
        $categories = ["Facebook", "X", "Youtube"];

        foreach ($categories as $c){
            $this->addSql("INSERT INTO `category` (`name`) VALUES ('{$c}')");
        }

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
