<?php declare (strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181109150955 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lord_colors CHANGE eyecolor_id eyecolor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_death_causes_secondary CHANGE deces_principal_id deces_principal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_backoffice_rat_messages CHANGE backoffice_rat_entry_id backoffice_rat_entry_id INT DEFAULT NULL, CHANGE user_staff_id user_staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_litters CHANGE rat_mother_id rat_mother_id INT DEFAULT NULL, CHANGE rat_father_id rat_father_id INT DEFAULT NULL, CHANGE user_owner_id user_owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_backoffice_rat_entries CHANGE rat_id rat_id INT DEFAULT NULL, CHANGE death_cause_primary_id death_cause_primary_id INT DEFAULT NULL, CHANGE death_cause_secondary_id death_cause_secondary_id INT DEFAULT NULL, CHANGE rattery_mother_id rattery_mother_id INT DEFAULT NULL, CHANGE rattery_father_id rattery_father_id INT DEFAULT NULL, CHANGE rat_mother_id rat_mother_id INT DEFAULT NULL, CHANGE rat_father_id rat_father_id INT DEFAULT NULL, CHANGE user_owner_id user_owner_id INT DEFAULT NULL, CHANGE color_id color_id INT DEFAULT NULL, CHANGE earset_id earset_id INT DEFAULT NULL, CHANGE eyecolor_id eyecolor_id INT DEFAULT NULL, CHANGE dilution_id dilution_id INT DEFAULT NULL, CHANGE coat_id coat_id INT DEFAULT NULL, CHANGE marking_id marking_id INT DEFAULT NULL, CHANGE user_creator_id user_creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_ratteries CHANGE user_owner_id user_owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_rats CHANGE death_cause_primary_id death_cause_primary_id INT DEFAULT NULL, CHANGE death_cause_secondary_id death_cause_secondary_id INT DEFAULT NULL, CHANGE rattery_mother_id rattery_mother_id INT DEFAULT NULL, CHANGE rattery_father_id rattery_father_id INT DEFAULT NULL, CHANGE rat_mother_id rat_mother_id INT DEFAULT NULL, CHANGE rat_father_id rat_father_id INT DEFAULT NULL, CHANGE litter_id litter_id INT DEFAULT NULL, CHANGE user_owner_id user_owner_id INT DEFAULT NULL, CHANGE color_id color_id INT DEFAULT NULL, CHANGE earset_id earset_id INT DEFAULT NULL, CHANGE eyecolor_id eyecolor_id INT DEFAULT NULL, CHANGE dilution_id dilution_id INT DEFAULT NULL, CHANGE coat_id coat_id INT DEFAULT NULL, CHANGE marking_id marking_id INT DEFAULT NULL, CHANGE user_creator_id user_creator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_backoffice_rattery_messages CHANGE rattery_id rattery_id INT DEFAULT NULL, CHANGE user_staff_id user_staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_users CHANGE email email VARCHAR(190) NOT NULL, CHANGE username username VARCHAR(25) NOT NULL, CHANGE roles roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_157ED430F85E0677 ON lord_users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_157ED430E7927C74 ON lord_users (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lord_backoffice_rat_entries CHANGE color_id color_id INT DEFAULT NULL, CHANGE death_cause_primary_id death_cause_primary_id INT DEFAULT NULL, CHANGE user_creator_id user_creator_id INT DEFAULT NULL, CHANGE rat_mother_id rat_mother_id INT DEFAULT NULL, CHANGE earset_id earset_id INT DEFAULT NULL, CHANGE rattery_mother_id rattery_mother_id INT DEFAULT NULL, CHANGE rat_father_id rat_father_id INT DEFAULT NULL, CHANGE eyecolor_id eyecolor_id INT DEFAULT NULL, CHANGE user_owner_id user_owner_id INT DEFAULT NULL, CHANGE death_cause_secondary_id death_cause_secondary_id INT DEFAULT NULL, CHANGE dilution_id dilution_id INT DEFAULT NULL, CHANGE rat_id rat_id INT DEFAULT NULL, CHANGE marking_id marking_id INT DEFAULT NULL, CHANGE rattery_father_id rattery_father_id INT DEFAULT NULL, CHANGE coat_id coat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_backoffice_rat_messages CHANGE backoffice_rat_entry_id backoffice_rat_entry_id INT DEFAULT NULL, CHANGE user_staff_id user_staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_backoffice_rattery_messages CHANGE rattery_id rattery_id INT DEFAULT NULL, CHANGE user_staff_id user_staff_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_colors CHANGE eyecolor_id eyecolor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_death_causes_secondary CHANGE deces_principal_id deces_principal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_litters CHANGE rat_mother_id rat_mother_id INT DEFAULT NULL, CHANGE rat_father_id rat_father_id INT DEFAULT NULL, CHANGE user_owner_id user_owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_rats CHANGE color_id color_id INT DEFAULT NULL, CHANGE death_cause_primary_id death_cause_primary_id INT DEFAULT NULL, CHANGE user_creator_id user_creator_id INT DEFAULT NULL, CHANGE rat_mother_id rat_mother_id INT DEFAULT NULL, CHANGE earset_id earset_id INT DEFAULT NULL, CHANGE rattery_mother_id rattery_mother_id INT DEFAULT NULL, CHANGE rat_father_id rat_father_id INT DEFAULT NULL, CHANGE eyecolor_id eyecolor_id INT DEFAULT NULL, CHANGE user_owner_id user_owner_id INT DEFAULT NULL, CHANGE death_cause_secondary_id death_cause_secondary_id INT DEFAULT NULL, CHANGE dilution_id dilution_id INT DEFAULT NULL, CHANGE litter_id litter_id INT DEFAULT NULL, CHANGE marking_id marking_id INT DEFAULT NULL, CHANGE rattery_father_id rattery_father_id INT DEFAULT NULL, CHANGE coat_id coat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lord_ratteries CHANGE user_owner_id user_owner_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_157ED430F85E0677 ON lord_users');
        $this->addSql('DROP INDEX UNIQ_157ED430E7927C74 ON lord_users');
        $this->addSql('ALTER TABLE lord_users CHANGE username username VARCHAR(45) DEFAULT \'NULL\' COLLATE utf8mb4_general_ci, CHANGE password password VARCHAR(64) DEFAULT \'NULL\' COLLATE utf8mb4_general_ci, CHANGE email email VARCHAR(70) NOT NULL COLLATE utf8mb4_general_ci, CHANGE is_active is_active VARCHAR(45) DEFAULT \'\'0\'\' COLLATE utf8mb4_general_ci, CHANGE roles roles LONGTEXT DEFAULT NULL COLLATE utf8mb4_general_ci');
    }
}
