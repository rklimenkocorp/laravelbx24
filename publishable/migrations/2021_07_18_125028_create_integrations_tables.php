<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegrationsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b24_activities', function (Blueprint $table) {
            $table->integer('ASSOCIATED_ENTITY_ID')->nullable()->index();
            $table->integer('AUTHOR_ID')->nullable()->index();
            $table->string('COMPLETED')->nullable();

            $table->dateTime('CREATED')->nullable();
            $table->dateTime('DEADLINE')->nullable();

            $table->text('DESCRIPTION')->nullable();
            $table->string('DIRECTION')->nullable();
            $table->integer('EDITOR_ID')->nullable()->index();

            $table->dateTime('END_TIME')->nullable();

            $table->integer('ID')->nullable()->index();

            $table->dateTime('LAST_UPDATED')->nullable();

            $table->integer('OWNER_ID')->nullable()->index();
            $table->integer('OWNER_TYPE_ID')->nullable()->index();
            $table->string('PRIORITY')->nullable();
            $table->integer('RESPONSIBLE_ID')->nullable()->index();
            $table->string('PROVIDER_TYPE_ID')->nullable()->index();
            $table->string('PROVIDER_ID')->nullable()->index();

            $table->dateTime('START_TIME')->nullable();

            $table->json('SETTINGS')->nullable();
            $table->string('STATUS')->nullable();
            $table->string('SUBJECT')->nullable();
            $table->integer('TYPE_ID')->nullable()->index();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_companies', function (Blueprint $table) {
            $table->integer('ID')->nullable()->index();
            $table->string('TITLE')->nullable();
            $table->string('COMPANY_TYPE')->nullable()->index();
            $table->integer('ASSIGNED_BY_ID')->nullable()->index();
            $table->integer('CREATED_BY_ID')->nullable()->index();
            $table->integer('MODIFY_BY_ID')->nullable()->index();
            $table->string('COMMENTS')->nullable();
            $table->dateTime('DATE_CREATE')->nullable();
            $table->dateTime('DATE_MODIFY')->nullable();
            $table->string('ORIGIN_ID')->nullable()->index();
            $table->string('UF_CRM_COMPANYINN')->nullable()->index();
            $table->string('UF_CRM_COMPANYKPP')->nullable()->index();
            $table->string('UF_CRM_POTENTIAL')->nullable();
            $table->string('UF_MAIN_COMPANY_YN')->nullable()->index();
            $table->text('UF_HOLDING')->nullable();
            $table->string('UF_MAIN_COMPANY')->nullable()->index();
            $table->json('PHONE')->nullable();
            $table->json('EMAIL')->nullable();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_contacts', function (Blueprint $table) {
            $table->integer('ASSIGNED_BY_ID')->nullable()->index();
            $table->integer('COMPANY_ID')->nullable()->index();
            $table->integer('CREATED_BY_ID')->nullable()->index();
            $table->dateTime('DATE_CREATE')->nullable();
            $table->dateTime('DATE_MODIFY')->nullable();
            $table->integer('ID')->nullable()->index();
            $table->string('LAST_NAME')->nullable();
            $table->integer('MODIFY_BY_ID')->nullable()->index();
            $table->string('NAME')->nullable();
            $table->string('ORIGIN_ID')->nullable()->index();
            $table->json('PHONE')->nullable();
            $table->json('EMAIL')->nullable();
            $table->string('SECOND_NAME')->nullable();
            $table->string('TYPE_ID')->nullable()->index();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_dealproducts', function (Blueprint $table) {
            $table->double('DISCOUNT_RATE')->nullable();
            $table->double('DISCOUNT_SUM')->nullable();
            $table->integer('DISCOUNT_TYPE_ID')->nullable()->index();
            $table->integer('MEASURE_CODE')->nullable()->index();
            $table->string('MEASURE_NAME')->nullable();
            $table->string('ORIGINAL_PRODUCT_NAME')->nullable();
            $table->integer('OWNER_ID')->nullable()->index();
            $table->string('OWNER_TYPE')->nullable();
            $table->double('PRICE')->nullable();
            $table->double('PRICE_BRUTTO')->nullable();
            $table->double('PRICE_EXCLUSIVE')->nullable();
            $table->double('PRICE_NETTO')->nullable();
            $table->integer('PRODUCT_ID')->nullable()->index();
            $table->string('PRODUCT_NAME')->nullable();
            $table->double('QUANTITY')->nullable();
            $table->string('TAX_INCLUDED')->nullable();
            $table->double('TAX_RATE')->nullable();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_deals', function (Blueprint $table) {
            $table->integer('ID')->nullable()->index();
            $table->string('TITLE')->nullable();
            $table->string('TYPE_ID')->nullable()->index();
            $table->string('STAGE_ID')->nullable()->index();
            $table->double('OPPORTUNITY')->nullable();
            $table->integer('COMPANY_ID')->nullable()->index();
            $table->integer('CONTACT_ID')->nullable()->index();
            $table->integer('ASSIGNED_BY_ID')->nullable()->index();
            $table->integer('CREATED_BY_ID')->nullable()->index();
            $table->dateTime('DATE_CREATE')->nullable();
            $table->dateTime('DATE_MODIFY')->nullable();
            $table->string('COMMENTS')->nullable();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_leads', function (Blueprint $table) {
            $table->integer('ID')->nullable()->index();
            $table->string('TITLE')->nullable();
            $table->string('STATUS_ID')->nullable()->index();
            $table->string('STATUS_SEMANTIC_ID')->nullable()->index();
            $table->string('SOURCE_ID')->nullable()->index();
            $table->string('SOURCE_DESCRIPTION')->nullable();
            $table->string('SECOND_NAME')->nullable();
            $table->json('PHONE')->nullable();
            $table->string('ORIGIN_ID')->nullable()->index();
            $table->string('ORIGINATOR_ID')->nullable()->index();
            $table->double('OPPORTUNITY')->nullable();
            $table->string('CURRENCY_ID')->nullable();
            $table->integer('MODIFY_BY_ID')->nullable()->index();
            $table->string('LAST_NAME')->nullable();
            $table->string('COMMENTS')->nullable();
            $table->integer('CREATED_BY_ID')->nullable()->index();
            $table->integer('ASSIGNED_BY_ID')->nullable()->index();
            $table->integer('COMPANY_ID')->nullable()->index();
            $table->integer('CONTACT_ID')->nullable()->index();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_products', function (Blueprint $table) {
            $table->string('ACTIVE')->nullable()->index();
            $table->integer('CATALOG_ID')->nullable()->index();
            $table->string('CODE')->nullable();
            $table->integer('CREATED_BY')->nullable()->index();
            $table->dateTime('DATE_CREATE')->nullable();
            $table->text('DESCRIPTION')->nullable();
            $table->integer('ID')->nullable()->index();
            $table->string('MEASURE')->nullable();
            $table->integer('MODIFIED_BY')->nullable()->index();
            $table->string('NAME')->nullable();
            $table->double('PRICE')->nullable();
            $table->integer('SECTION_ID')->nullable()->index();
            $table->string('XML_ID')->nullable()->index();
            $table->json('CUSTOM_FIELDS')->nullable();
        });

        Schema::create('b24_requisities', function (Blueprint $table) {
            $table->string('ACTIVE')->nullable()->index();
            $table->integer('CREATED_BY_ID')->nullable()->index();
            $table->dateTIme('DATE_CREATE')->nullable();
            $table->dateTIme('DATE_MODIFY')->nullable();
            $table->integer('ENTITY_ID')->nullable()->index();
            $table->integer('ENTITY_TYPE_ID')->nullable()->index();
            $table->integer('ID')->nullable()->index();
            $table->integer('MODIFY_BY_ID')->nullable()->index();
            $table->string('NAME')->nullable();
            $table->string('ORIGINATOR_ID')->nullable()->index();
            $table->string('PRESET_ID')->nullable()->index();
            $table->string('RQ_COMPANY_FULL_NAME')->nullable();
            $table->string('RQ_COMPANY_NAME')->nullable();
            $table->string('RQ_COMPANY_REG_DATE')->nullable();
            $table->string('RQ_CONTACT')->nullable();
            $table->string('RQ_DIRECTOR')->nullable();
            $table->string('RQ_FIRST_NAME')->nullable();
            $table->string('RQ_EMAIL')->nullable();
            $table->string('RQ_IFNS')->nullable();
            $table->string('RQ_INN')->nullable();
            $table->string('RQ_LAST_NAME')->nullable();
            $table->string('RQ_NAME')->nullable();
            $table->string('RQ_OGRN')->nullable();
            $table->string('RQ_OGRNIP')->nullable();
            $table->string('RQ_OKVED')->nullable();
            $table->string('RQ_PHONE')->nullable();
            $table->string('RQ_SECOND_NAME')->nullable();
            $table->string('XML_ID')->nullable()->index();
            $table->json('CUSTOM_FIELDS')->nullable();

        });

        Schema::create('b24_tasks', function (Blueprint $table) {
            $table->json('accomplices')->nullable();
            $table->dateTime('activityDate')->nullable();
            $table->json('auditors')->nullable();
            $table->integer('changedBy')->nullable()->index();
            $table->dateTime('changedDate')->nullable();
            $table->integer('createdBy')->nullable()->index();
            $table->dateTime('createdDate')->nullable();
            $table->dateTime('closedDate')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->text('description')->nullable();
            $table->integer('forumId')->nullable()->index();
            $table->integer('forumTopicId')->nullable()->index();
            $table->integer('groupId')->nullable()->index();
            $table->json('group')->nullable();
            $table->string('guid')->nullable()->index();
            $table->integer('id')->nullable()->index();
            $table->string('responsibleId')->nullable()->index();
            $table->string('status')->nullable()->index();
            $table->string('statusChangedBy')->nullable()->index();
            $table->string('stageId')->nullable()->index();
            $table->string('title')->nullable();
            $table->json('CUSTOM_FIELDS')->nullable();
        });


        Schema::create('b24_users', function (Blueprint $table) {
            $table->integer('ID')->nullable()->index();
            $table->string('ACTIVE')->nullable();
            $table->string('EMAIL')->nullable();
            $table->dateTime('DATE_REGISTER')->nullable();
            $table->string('NAME')->nullable();
            $table->string('LAST_NAME')->nullable();
            $table->string('SECOND_NAME')->nullable();
            $table->dateTime('PERSONAL_BIRTHDAY')->nullable();
            $table->string('PERSONAL_GENDER')->nullable();
            $table->string('PERSONAL_PHOTO')->nullable();
            $table->string('PERSONAL_PHONE')->nullable();
            $table->string('PERSONAL_MOBILE')->nullable();
            $table->string('PERSONAL_CITY')->nullable();
            $table->string('PERSONAL_STATE')->nullable();
            $table->string('WORK_POSITION')->nullable();
            $table->json('UF_DEPARTMENT')->nullable();
            $table->json('CUSTOM_FIELDS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b24_activities');
        Schema::dropIfExists('b24_companies');
        Schema::dropIfExists('b24_contacts');
        Schema::dropIfExists('b24_dealproducts');
        Schema::dropIfExists('b24_deals');
        Schema::dropIfExists('b24_leads');
        Schema::dropIfExists('b24_products');
        Schema::dropIfExists('b24_requisities');
        Schema::dropIfExists('b24_tasks');
    }
}
