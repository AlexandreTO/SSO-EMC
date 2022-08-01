<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220801095424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD speciality VARCHAR(255) NOT NULL, ADD address1 VARCHAR(255) NOT NULL, ADD address2 VARCHAR(255) DEFAULT NULL, ADD address3 VARCHAR(255) DEFAULT NULL, ADD zipcode VARCHAR(5) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD state VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) NOT NULL, ADD website VARCHAR(255) DEFAULT NULL, ADD photo VARCHAR(255) DEFAULT NULL, ADD bio LONGTEXT DEFAULT NULL, ADD phone1 VARCHAR(255) DEFAULT NULL, ADD phone2 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP speciality, DROP address1, DROP address2, DROP address3, DROP zipcode, DROP city, DROP state, DROP country, DROP website, DROP photo, DROP bio, DROP phone1, DROP phone2');
    }
}
