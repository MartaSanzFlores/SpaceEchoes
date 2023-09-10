<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822132818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_user (picture_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_327353DCEE45BDBF (picture_id), INDEX IDX_327353DCA76ED395 (user_id), PRIMARY KEY(picture_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (post_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B9A190604B89032C (post_id), INDEX IDX_B9A1906012469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review_user (review_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6F279B513E2E969B (review_id), INDEX IDX_6F279B51A76ED395 (user_id), PRIMARY KEY(review_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture_user ADD CONSTRAINT FK_327353DCEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_user ADD CONSTRAINT FK_327353DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review_user ADD CONSTRAINT FK_6F279B513E2E969B FOREIGN KEY (review_id) REFERENCES review (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review_user ADD CONSTRAINT FK_6F279B51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD user_picture_id INT NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8949227B53 FOREIGN KEY (user_picture_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8949227B53 ON picture (user_picture_id)');
        $this->addSql('ALTER TABLE post ADD author_id INT NOT NULL, ADD picture_id INT NOT NULL, ADD user_post_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D13841D26 FOREIGN KEY (user_post_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8DEE45BDBF ON post (picture_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D13841D26 ON post (user_post_id)');
        $this->addSql('ALTER TABLE review ADD post_id INT NOT NULL, ADD user_review_id INT NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C63ECE1B7F FOREIGN KEY (user_review_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_794381C64B89032C ON review (post_id)');
        $this->addSql('CREATE INDEX IDX_794381C63ECE1B7F ON review (user_review_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture_user DROP FOREIGN KEY FK_327353DCEE45BDBF');
        $this->addSql('ALTER TABLE picture_user DROP FOREIGN KEY FK_327353DCA76ED395');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A190604B89032C');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A1906012469DE2');
        $this->addSql('ALTER TABLE review_user DROP FOREIGN KEY FK_6F279B513E2E969B');
        $this->addSql('ALTER TABLE review_user DROP FOREIGN KEY FK_6F279B51A76ED395');
        $this->addSql('DROP TABLE picture_user');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE review_user');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64B89032C');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C63ECE1B7F');
        $this->addSql('DROP INDEX IDX_794381C64B89032C ON review');
        $this->addSql('DROP INDEX IDX_794381C63ECE1B7F ON review');
        $this->addSql('ALTER TABLE review DROP post_id, DROP user_review_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8949227B53');
        $this->addSql('DROP INDEX IDX_16DB4F8949227B53 ON picture');
        $this->addSql('ALTER TABLE picture DROP user_picture_id');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DEE45BDBF');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D13841D26');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B ON post');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8DEE45BDBF ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8D13841D26 ON post');
        $this->addSql('ALTER TABLE post DROP author_id, DROP picture_id, DROP user_post_id');
    }
}
