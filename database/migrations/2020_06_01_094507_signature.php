<?php


    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class Signature extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            //
            Schema::create(
                'signatures', function ( Blueprint $table ) {
                $table->id();
                $table->unsignedTinyInteger('erp_user_id')->comment('ERP User Id');
                $table->longText('image_base64')->comment('imageBase64');
                $table->unsignedTinyInteger('favorite')->comment('設為預設簽名');
                $table->timestamps();
                $table->softDeletes();
            }
            );
            DB::statement("ALTER TABLE `signatures` comment'簽名檔'");
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('signatures');
        }
    }
