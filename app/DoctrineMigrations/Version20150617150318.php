<?php

namespace Anar\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150617150318 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vbee_setting (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_24949F99232D562B (object_id), UNIQUE INDEX group_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_roles (id INT AUTO_INCREMENT NOT NULL, app_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CC7CC84B57698A6A (role), INDEX IDX_CC7CC84B7987212D (app_id), INDEX IDX_CC7CC84B727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_app (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_77F265F75E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_9C6B3500232D562B (object_id), UNIQUE INDEX blog_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_log (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, createdAt DATETIME NOT NULL, createdBy VARCHAR(255) DEFAULT NULL, routeParams LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', postParams LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ip VARCHAR(45) DEFAULT NULL, entity VARCHAR(255) NOT NULL, event VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_31A37DFDDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_grade (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_app_menu (id INT AUTO_INCREMENT NOT NULL, app_id INT DEFAULT NULL, role_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, route VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, INDEX IDX_F2897B7987212D (app_id), INDEX IDX_F2897BD60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, theme_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, name VARCHAR(100) NOT NULL, on_tree TINYINT(1) DEFAULT \'1\' NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, lft SMALLINT NOT NULL, rgt SMALLINT NOT NULL, root SMALLINT DEFAULT NULL, lvl SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C01551435E237E06 (name), INDEX IDX_C0155143727ACA70 (parent_id), INDEX IDX_C015514359027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blogs_apps (blog_id INT NOT NULL, app_id INT NOT NULL, INDEX IDX_CDB888C4DAE07E97 (blog_id), INDEX IDX_CDB888C47987212D (app_id), PRIMARY KEY(blog_id, app_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F24CEBFA92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_F24CEBFAA0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, code VARCHAR(20) NOT NULL, icon VARCHAR(255) NOT NULL, direction VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, is_default TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) NOT NULL, locked TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, INDEX IDX_F06D3970DAE07E97 (blog_id), UNIQUE INDEX groups_name_unique_idx (blog_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups_roles (group_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_E79D4963FE54D947 (group_id), INDEX IDX_E79D4963D60322AC (role_id), PRIMARY KEY(group_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, grade_id INT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, fname VARCHAR(255) NOT NULL, lname VARCHAR(255) NOT NULL, faname VARCHAR(255) DEFAULT NULL, staff_code INT NOT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_1483A5E995234617 (staff_code), INDEX IDX_1483A5E9FE19A1A8 (grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_FF8AB7E0A76ED395 (user_id), INDEX IDX_FF8AB7E0FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_app_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_8ECABCB1232D562B (object_id), UNIQUE INDEX app_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sys_theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, direction LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_ED3701845E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, icon VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_36AC99F112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_category (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_CBE67908DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_34185A45232D562B (object_id), UNIQUE INDEX link_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor_education (id INT AUTO_INCREMENT NOT NULL, grade_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, university VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, startDate DATE NOT NULL, endDate DATE NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_D8D0E564FE19A1A8 (grade_id), INDEX IDX_D8D0E564CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor_profile (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, telephone VARCHAR(15) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, bio TEXT DEFAULT NULL, job_started_at DATE DEFAULT NULL, skill TEXT DEFAULT NULL, favorite TEXT DEFAULT NULL, article TEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DE78C55BDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor_students_dissertation_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_5A97A506232D562B (object_id), UNIQUE INDEX professor_profile_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor_profile_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_BF9193B0232D562B (object_id), UNIQUE INDEX professor_profile_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor_students_dissertation (id INT AUTO_INCREMENT NOT NULL, grade_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, abstract VARCHAR(1000) NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_EDF02FCEFE19A1A8 (grade_id), INDEX IDX_EDF02FCECCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professor_plan (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, startTime TIME NOT NULL, endTime TIME NOT NULL, dayNumber SMALLINT NOT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_A2AD46A5CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_article_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_DAEE331C232D562B (object_id), UNIQUE INDEX content_article_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, blog_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, slug VARCHAR(255) NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, root INT NOT NULL, lvl INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_54FBF32E727ACA70 (parent_id), INDEX IDX_54FBF32EDAE07E97 (blog_id), UNIQUE INDEX content_category_unique_idx (blog_id, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_article (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, editor_id INT DEFAULT NULL, category_id INT DEFAULT NULL, blog_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, abstract LONGTEXT NOT NULL, article LONGTEXT DEFAULT NULL, visit INT DEFAULT 0 NOT NULL, enabled TINYINT(1) DEFAULT \'1\' NOT NULL, publication_start DATE DEFAULT NULL, publication_end DATE DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, attach VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_DD32D7D5F675F31B (author_id), INDEX IDX_DD32D7D56995AC4C (editor_id), INDEX IDX_DD32D7D512469DE2 (category_id), INDEX IDX_DD32D7D5DAE07E97 (blog_id), UNIQUE INDEX content_article_unique_idx (blog_id, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_category_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, createdBy VARCHAR(255) NOT NULL, updatedBy VARCHAR(255) NOT NULL, INDEX IDX_FC7A0595232D562B (object_id), UNIQUE INDEX content_category_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_translations (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, INDEX IDX_B9B52B22232D562B (object_id), UNIQUE INDEX menu_translations_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, blog_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, root INT NOT NULL, level INT NOT NULL, INDEX IDX_7D053A93727ACA70 (parent_id), INDEX IDX_7D053A93DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slide_show_image (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) NOT NULL, updated_by VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8EAE5A17DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, blog_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, message LONGTEXT NOT NULL, INDEX IDX_4C62E638DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groups_translations ADD CONSTRAINT FK_24949F99232D562B FOREIGN KEY (object_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sys_roles ADD CONSTRAINT FK_CC7CC84B7987212D FOREIGN KEY (app_id) REFERENCES sys_app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sys_roles ADD CONSTRAINT FK_CC7CC84B727ACA70 FOREIGN KEY (parent_id) REFERENCES sys_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_translations ADD CONSTRAINT FK_9C6B3500232D562B FOREIGN KEY (object_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sys_log ADD CONSTRAINT FK_31A37DFDDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sys_app_menu ADD CONSTRAINT FK_F2897B7987212D FOREIGN KEY (app_id) REFERENCES sys_app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sys_app_menu ADD CONSTRAINT FK_F2897BD60322AC FOREIGN KEY (role_id) REFERENCES sys_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143727ACA70 FOREIGN KEY (parent_id) REFERENCES blog (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514359027487 FOREIGN KEY (theme_id) REFERENCES sys_theme (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE blogs_apps ADD CONSTRAINT FK_CDB888C4DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blogs_apps ADD CONSTRAINT FK_CDB888C47987212D FOREIGN KEY (app_id) REFERENCES sys_app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groups ADD CONSTRAINT FK_F06D3970DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groups_roles ADD CONSTRAINT FK_E79D4963FE54D947 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groups_roles ADD CONSTRAINT FK_E79D4963D60322AC FOREIGN KEY (role_id) REFERENCES sys_roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9FE19A1A8 FOREIGN KEY (grade_id) REFERENCES sys_grade (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sys_app_translations ADD CONSTRAINT FK_8ECABCB1232D562B FOREIGN KEY (object_id) REFERENCES sys_app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F112469DE2 FOREIGN KEY (category_id) REFERENCES link_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link_category ADD CONSTRAINT FK_CBE67908DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE link_translations ADD CONSTRAINT FK_34185A45232D562B FOREIGN KEY (object_id) REFERENCES link (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professor_education ADD CONSTRAINT FK_D8D0E564FE19A1A8 FOREIGN KEY (grade_id) REFERENCES sys_grade (id)');
        $this->addSql('ALTER TABLE professor_education ADD CONSTRAINT FK_D8D0E564CCFA12B8 FOREIGN KEY (profile_id) REFERENCES professor_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professor_profile ADD CONSTRAINT FK_DE78C55BDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professor_students_dissertation_translations ADD CONSTRAINT FK_5A97A506232D562B FOREIGN KEY (object_id) REFERENCES professor_students_dissertation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professor_profile_translations ADD CONSTRAINT FK_BF9193B0232D562B FOREIGN KEY (object_id) REFERENCES professor_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professor_students_dissertation ADD CONSTRAINT FK_EDF02FCEFE19A1A8 FOREIGN KEY (grade_id) REFERENCES sys_grade (id)');
        $this->addSql('ALTER TABLE professor_students_dissertation ADD CONSTRAINT FK_EDF02FCECCFA12B8 FOREIGN KEY (profile_id) REFERENCES professor_profile (id)');
        $this->addSql('ALTER TABLE professor_plan ADD CONSTRAINT FK_A2AD46A5CCFA12B8 FOREIGN KEY (profile_id) REFERENCES professor_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_article_translations ADD CONSTRAINT FK_DAEE331C232D562B FOREIGN KEY (object_id) REFERENCES content_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_category ADD CONSTRAINT FK_54FBF32E727ACA70 FOREIGN KEY (parent_id) REFERENCES content_category (id)');
        $this->addSql('ALTER TABLE content_category ADD CONSTRAINT FK_54FBF32EDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE content_article ADD CONSTRAINT FK_DD32D7D5F675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_article ADD CONSTRAINT FK_DD32D7D56995AC4C FOREIGN KEY (editor_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_article ADD CONSTRAINT FK_DD32D7D512469DE2 FOREIGN KEY (category_id) REFERENCES content_category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE content_article ADD CONSTRAINT FK_DD32D7D5DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE content_category_translations ADD CONSTRAINT FK_FC7A0595232D562B FOREIGN KEY (object_id) REFERENCES content_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_translations ADD CONSTRAINT FK_B9B52B22232D562B FOREIGN KEY (object_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93727ACA70 FOREIGN KEY (parent_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE slide_show_image ADD CONSTRAINT FK_8EAE5A17DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sys_roles DROP FOREIGN KEY FK_CC7CC84B727ACA70');
        $this->addSql('ALTER TABLE sys_app_menu DROP FOREIGN KEY FK_F2897BD60322AC');
        $this->addSql('ALTER TABLE groups_roles DROP FOREIGN KEY FK_E79D4963D60322AC');
        $this->addSql('ALTER TABLE sys_roles DROP FOREIGN KEY FK_CC7CC84B7987212D');
        $this->addSql('ALTER TABLE sys_app_menu DROP FOREIGN KEY FK_F2897B7987212D');
        $this->addSql('ALTER TABLE blogs_apps DROP FOREIGN KEY FK_CDB888C47987212D');
        $this->addSql('ALTER TABLE sys_app_translations DROP FOREIGN KEY FK_8ECABCB1232D562B');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9FE19A1A8');
        $this->addSql('ALTER TABLE professor_education DROP FOREIGN KEY FK_D8D0E564FE19A1A8');
        $this->addSql('ALTER TABLE professor_students_dissertation DROP FOREIGN KEY FK_EDF02FCEFE19A1A8');
        $this->addSql('ALTER TABLE blog_translations DROP FOREIGN KEY FK_9C6B3500232D562B');
        $this->addSql('ALTER TABLE sys_log DROP FOREIGN KEY FK_31A37DFDDAE07E97');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143727ACA70');
        $this->addSql('ALTER TABLE blogs_apps DROP FOREIGN KEY FK_CDB888C4DAE07E97');
        $this->addSql('ALTER TABLE groups DROP FOREIGN KEY FK_F06D3970DAE07E97');
        $this->addSql('ALTER TABLE link_category DROP FOREIGN KEY FK_CBE67908DAE07E97');
        $this->addSql('ALTER TABLE professor_profile DROP FOREIGN KEY FK_DE78C55BDAE07E97');
        $this->addSql('ALTER TABLE content_category DROP FOREIGN KEY FK_54FBF32EDAE07E97');
        $this->addSql('ALTER TABLE content_article DROP FOREIGN KEY FK_DD32D7D5DAE07E97');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93DAE07E97');
        $this->addSql('ALTER TABLE slide_show_image DROP FOREIGN KEY FK_8EAE5A17DAE07E97');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638DAE07E97');
        $this->addSql('ALTER TABLE groups_translations DROP FOREIGN KEY FK_24949F99232D562B');
        $this->addSql('ALTER TABLE groups_roles DROP FOREIGN KEY FK_E79D4963FE54D947');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('ALTER TABLE content_article DROP FOREIGN KEY FK_DD32D7D5F675F31B');
        $this->addSql('ALTER TABLE content_article DROP FOREIGN KEY FK_DD32D7D56995AC4C');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C015514359027487');
        $this->addSql('ALTER TABLE link_translations DROP FOREIGN KEY FK_34185A45232D562B');
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F112469DE2');
        $this->addSql('ALTER TABLE professor_education DROP FOREIGN KEY FK_D8D0E564CCFA12B8');
        $this->addSql('ALTER TABLE professor_profile_translations DROP FOREIGN KEY FK_BF9193B0232D562B');
        $this->addSql('ALTER TABLE professor_students_dissertation DROP FOREIGN KEY FK_EDF02FCECCFA12B8');
        $this->addSql('ALTER TABLE professor_plan DROP FOREIGN KEY FK_A2AD46A5CCFA12B8');
        $this->addSql('ALTER TABLE professor_students_dissertation_translations DROP FOREIGN KEY FK_5A97A506232D562B');
        $this->addSql('ALTER TABLE content_category DROP FOREIGN KEY FK_54FBF32E727ACA70');
        $this->addSql('ALTER TABLE content_article DROP FOREIGN KEY FK_DD32D7D512469DE2');
        $this->addSql('ALTER TABLE content_category_translations DROP FOREIGN KEY FK_FC7A0595232D562B');
        $this->addSql('ALTER TABLE content_article_translations DROP FOREIGN KEY FK_DAEE331C232D562B');
        $this->addSql('ALTER TABLE menu_translations DROP FOREIGN KEY FK_B9B52B22232D562B');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93727ACA70');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE vbee_setting');
        $this->addSql('DROP TABLE groups_translations');
        $this->addSql('DROP TABLE sys_roles');
        $this->addSql('DROP TABLE sys_app');
        $this->addSql('DROP TABLE blog_translations');
        $this->addSql('DROP TABLE sys_log');
        $this->addSql('DROP TABLE sys_grade');
        $this->addSql('DROP TABLE sys_app_menu');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blogs_apps');
        $this->addSql('DROP TABLE sys_admin');
        $this->addSql('DROP TABLE sys_language');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP TABLE groups_roles');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_groups');
        $this->addSql('DROP TABLE sys_app_translations');
        $this->addSql('DROP TABLE sys_theme');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE link_category');
        $this->addSql('DROP TABLE link_translations');
        $this->addSql('DROP TABLE professor_education');
        $this->addSql('DROP TABLE professor_profile');
        $this->addSql('DROP TABLE professor_students_dissertation_translations');
        $this->addSql('DROP TABLE professor_profile_translations');
        $this->addSql('DROP TABLE professor_students_dissertation');
        $this->addSql('DROP TABLE professor_plan');
        $this->addSql('DROP TABLE content_article_translations');
        $this->addSql('DROP TABLE content_category');
        $this->addSql('DROP TABLE content_article');
        $this->addSql('DROP TABLE content_category_translations');
        $this->addSql('DROP TABLE menu_translations');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE slide_show_image');
        $this->addSql('DROP TABLE contact');
    }
}
