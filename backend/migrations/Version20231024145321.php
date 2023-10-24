<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024145321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Posts table migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $schema->createTable('posts', function (Table $table) {
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('title', 'string', ['length' => 255]);
            $table->addColumn('content', 'text');
        });
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('posts');
    }
}
