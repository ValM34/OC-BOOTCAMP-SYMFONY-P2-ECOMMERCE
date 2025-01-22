<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122125524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "order" (id SERIAL NOT NULL, customer_id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F52993989395C3F3 ON "order" (customer_id)');
        $this->addSql('CREATE TABLE ordered_product (id SERIAL NOT NULL, product_id INT NOT NULL, order_item_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6F097B64584665A ON ordered_product (product_id)');
        $this->addSql('CREATE INDEX IDX_E6F097B6E415FB15 ON ordered_product (order_item_id)');
        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, short_description VARCHAR(255) NOT NULL, full_description VARCHAR(255) NOT NULL, price INT NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ordered_product ADD CONSTRAINT FK_E6F097B64584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ordered_product ADD CONSTRAINT FK_E6F097B6E415FB15 FOREIGN KEY (order_item_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE ordered_product DROP CONSTRAINT FK_E6F097B64584665A');
        $this->addSql('ALTER TABLE ordered_product DROP CONSTRAINT FK_E6F097B6E415FB15');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE ordered_product');
        $this->addSql('DROP TABLE product');
    }
}
