<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateProductsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->integer('stock');
            $table->integer('stoks');
            $table->string('image');
            $table->integer('category_id')->unsigned();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::disableForeignKeyConstraints(); // Matikan sementara foreign key check

    Schema::dropIfExists('order_product'); // Hapus tabel terkait dulu
    Schema::dropIfExists('products');      // Baru hapus tabel utama

    Schema::enableForeignKeyConstraints(); // Aktifkan kembali foreign key check
}

}