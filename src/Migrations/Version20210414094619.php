<?php

declare(strict_types=1);

namespace User\Balance\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414094619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table `user`';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE user
                (
                    id int auto_increment primary key,
                    name varchar(256),
                    email varchar(100),
                    gender tinyint,
                    address text,
                    balance float default 0.00,
                    status tinyint default 0,
                    created_at timestamp default CURRENT_TIMESTAMP,
                    updated_at timestamp default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );
        ');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE sagas');

    }
}
