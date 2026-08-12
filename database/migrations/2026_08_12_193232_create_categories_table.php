public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();

        $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();

        $table->string('name');
        $table->string('slug')->unique();

        $table->text('description')->nullable();

        $table->string('image')->nullable();
        $table->string('icon')->nullable();
        $table->string('banner')->nullable();

        $table->integer('sort_order')->default(0);

        $table->boolean('is_featured')->default(false);
        $table->boolean('status')->default(true);

        $table->string('meta_title')->nullable();
        $table->text('meta_keywords')->nullable();
        $table->text('meta_description')->nullable();

        $table->timestamps();
    });
}