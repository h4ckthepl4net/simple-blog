<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024144437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Categories table migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $schema->createTable('categories', function (Table $table) {
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('name', 'string', ['length' => 255]);
            $table->setPrimaryKey(['id']);
        });
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('categories');
    }
}
