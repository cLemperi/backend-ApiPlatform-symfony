<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016142441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE curiculum (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, curiculum_file VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, content VARCHAR(700) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_contact (id INT AUTO_INCREMENT NOT NULL, sex VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, profession VARCHAR(255) DEFAULT NULL, etablissement VARCHAR(255) DEFAULT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, message_title VARCHAR(255) DEFAULT NULL, message VARCHAR(600) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formations (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, price VARCHAR(255) DEFAULT NULL, for_who VARCHAR(255) DEFAULT NULL, prerequisite VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_formation VARCHAR(255) DEFAULT NULL, duration_formation VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, intervenant VARCHAR(255) DEFAULT NULL, evaluation VARCHAR(255) DEFAULT NULL, public_acces_and_condition VARCHAR(255) DEFAULT NULL, programme_pedago_file VARCHAR(255) DEFAULT NULL, INDEX IDX_4090213712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formations_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, formations_id INT NOT NULL, INDEX IDX_D653FD6AA76ED395 (user_id), INDEX IDX_D653FD6A3BF5B0C2 (formations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectif_formation (id INT AUTO_INCREMENT NOT NULL, formations_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(500) DEFAULT NULL, INDEX IDX_400F6A93BF5B0C2 (formations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme_formation (id INT AUTO_INCREMENT NOT NULL, formations_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(500) DEFAULT NULL, INDEX IDX_905A86B13BF5B0C2 (formations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_from (id INT AUTO_INCREMENT NOT NULL, user_from_id INT DEFAULT NULL, nickname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, job VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_C39BEDB920C3C701 (user_from_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_from_formations (user_from_id INT NOT NULL, formations_id INT NOT NULL, INDEX IDX_79E88BBF20C3C701 (user_from_id), INDEX IDX_79E88BBF3BF5B0C2 (formations_id), PRIMARY KEY(user_from_id, formations_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_message (id INT AUTO_INCREMENT NOT NULL, user_message_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, is_archived TINYINT(1) NOT NULL, INDEX IDX_EEB02E75F41DD5C5 (user_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formations ADD CONSTRAINT FK_4090213712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE formations_user ADD CONSTRAINT FK_D653FD6AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE formations_user ADD CONSTRAINT FK_D653FD6A3BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id)');
        $this->addSql('ALTER TABLE objectif_formation ADD CONSTRAINT FK_400F6A93BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id)');
        $this->addSql('ALTER TABLE programme_formation ADD CONSTRAINT FK_905A86B13BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id)');
        $this->addSql('ALTER TABLE user_from ADD CONSTRAINT FK_C39BEDB920C3C701 FOREIGN KEY (user_from_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_from_formations ADD CONSTRAINT FK_79E88BBF20C3C701 FOREIGN KEY (user_from_id) REFERENCES user_from (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_from_formations ADD CONSTRAINT FK_79E88BBF3BF5B0C2 FOREIGN KEY (formations_id) REFERENCES formations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_message ADD CONSTRAINT FK_EEB02E75F41DD5C5 FOREIGN KEY (user_message_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formations DROP FOREIGN KEY FK_4090213712469DE2');
        $this->addSql('ALTER TABLE formations_user DROP FOREIGN KEY FK_D653FD6AA76ED395');
        $this->addSql('ALTER TABLE formations_user DROP FOREIGN KEY FK_D653FD6A3BF5B0C2');
        $this->addSql('ALTER TABLE objectif_formation DROP FOREIGN KEY FK_400F6A93BF5B0C2');
        $this->addSql('ALTER TABLE programme_formation DROP FOREIGN KEY FK_905A86B13BF5B0C2');
        $this->addSql('ALTER TABLE user_from DROP FOREIGN KEY FK_C39BEDB920C3C701');
        $this->addSql('ALTER TABLE user_from_formations DROP FOREIGN KEY FK_79E88BBF20C3C701');
        $this->addSql('ALTER TABLE user_from_formations DROP FOREIGN KEY FK_79E88BBF3BF5B0C2');
        $this->addSql('ALTER TABLE user_message DROP FOREIGN KEY FK_EEB02E75F41DD5C5');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE curiculum');
        $this->addSql('DROP TABLE form_contact');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE formations_user');
        $this->addSql('DROP TABLE objectif_formation');
        $this->addSql('DROP TABLE programme_formation');
        $this->addSql('DROP TABLE user_from');
        $this->addSql('DROP TABLE user_from_formations');
        $this->addSql('DROP TABLE user_message');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP email, CHANGE roles roles JSON NOT NULL');
    }
}
