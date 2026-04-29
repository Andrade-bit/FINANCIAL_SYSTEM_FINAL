<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. encoderaddmoney
        if (!Schema::hasTable('encoderaddmoney')) {
            Schema::create('encoderaddmoney', function (Blueprint $table) {
                $table->id('encoderAddmoneyID');
                $table->decimal('amount', 15, 2)->default(0.00);
                $table->string('description')->nullable();
                $table->date('date');
                $table->timestamps();
            });
        }

        // 2. encoderaddexpenses
        if (!Schema::hasTable('encoderaddexpenses')) {
            Schema::create('encoderaddexpenses', function (Blueprint $table) {
                $table->id('encoderAddexpensesID');
                $table->decimal('amount', 15, 2)->default(0.00);
                $table->string('description')->nullable();
                $table->date('date');
                $table->timestamps();
            });
        }

        // 3. encoders
        if (!Schema::hasTable('encoders')) {
            Schema::create('encoders', function (Blueprint $table) {
                $table->id('encodersID');
                $table->unsignedBigInteger('encoderTransactionsID')->nullable();
                $table->unsignedBigInteger('encoderAddmoneyID')->nullable();
                $table->unsignedBigInteger('encoderAddexpensesID')->nullable();
                $table->unsignedBigInteger('usersID');
                $table->timestamps();

                $table->foreign('usersID', 'fk_encoders_user')
                    ->references('usersID')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('encoderAddmoneyID', 'fk_encoders_addmoney')
                    ->references('encoderAddmoneyID')->on('encoderaddmoney')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('encoderAddexpensesID', 'fk_encoders_addexpenses')
                    ->references('encoderAddexpensesID')->on('encoderaddexpenses')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }

        // 4. encoder_transactions
        if (!Schema::hasTable('encoder_transactions')) {
            Schema::create('encoder_transactions', function (Blueprint $table) {
                $table->id('encoderTransactionsID');
                $table->unsignedBigInteger('usersID');
                $table->unsignedBigInteger('encoderAddmoneyID')->nullable();
                $table->unsignedBigInteger('encoderAddexpensesID')->nullable();
                $table->date('date');
                $table->string('description')->nullable();
                $table->decimal('funds_amount', 15, 2)->default(0.00);
                $table->decimal('expenses_amount', 15, 2)->default(0.00);
                $table->enum('type', ['funds', 'expenses', 'both'])->default('funds');
                $table->text('notes')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->timestamps();

                $table->foreign('usersID', 'fk_enc_transaction_user')
                    ->references('usersID')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('encoderAddmoneyID', 'fk_enc_transaction_addmoney')
                    ->references('encoderAddmoneyID')->on('encoderaddmoney')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('encoderAddexpensesID', 'fk_enc_transaction_addexpenses')
                    ->references('encoderAddexpensesID')->on('encoderaddexpenses')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }

        // 5. treasureraddmoney
        if (!Schema::hasTable('treasureraddmoney')) {
            Schema::create('treasureraddmoney', function (Blueprint $table) {
                $table->id('treasurerAddmoneyID');
                $table->decimal('amount', 15, 2)->default(0.00);
                $table->string('description')->nullable();
                $table->date('date');
                $table->timestamps();
            });
        }

        // 6. treasureraddexpenses
        if (!Schema::hasTable('treasureraddexpenses')) {
            Schema::create('treasureraddexpenses', function (Blueprint $table) {
                $table->id('treasurerAddexpensesID');
                $table->decimal('amount', 15, 2)->default(0.00);
                $table->string('description')->nullable();
                $table->date('date');
                $table->timestamps();
            });
        }

        // 7. treasurer_dashboard
        if (!Schema::hasTable('treasurer_dashboard')) {
            Schema::create('treasurer_dashboard', function (Blueprint $table) {
                $table->id('treasurerDashboardID');
                $table->unsignedBigInteger('usersID')->unique();
                $table->decimal('total_balance', 15, 2)->default(0.00);
                $table->decimal('total_collections', 15, 2)->default(0.00);
                $table->decimal('total_expenses', 15, 2)->default(0.00);
                $table->text('monthly_overview')->nullable();

                $table->foreign('usersID', 'fk_dashboard_user')
                    ->references('usersID')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
            });
        }

        // 8. treasurer_transactions
        if (!Schema::hasTable('treasurer_transactions')) {
            Schema::create('treasurer_transactions', function (Blueprint $table) {
                $table->id('treasurerTransactionsID');
                $table->unsignedBigInteger('usersID');
                $table->unsignedBigInteger('treasurerAddmoneyID')->nullable();
                $table->unsignedBigInteger('treasurerAddexpensesID')->nullable();
                $table->enum('type', ['funds', 'expenses', 'both'])->default('funds');
                $table->string('description')->nullable();
                $table->decimal('funds_amount', 15, 2)->default(0.00);
                $table->decimal('expenses_amount', 15, 2)->default(0.00);
                $table->decimal('total_amount', 15, 2)->default(0.00);
                $table->date('date');
                $table->text('notes')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();

                $table->foreign('usersID', 'fk_transaction_user')
                    ->references('usersID')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('treasurerAddmoneyID', 'fk_transaction_addmoney')
                    ->references('treasurerAddmoneyID')->on('treasureraddmoney')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('treasurerAddexpensesID', 'fk_transaction_addexpenses')
                    ->references('treasurerAddexpensesID')->on('treasureraddexpenses')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('approved_by', 'fk_transaction_approved_by')
                    ->references('usersID')->on('users')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }

        // 9. treasurerquickacts
        if (!Schema::hasTable('treasurerquickacts')) {
            Schema::create('treasurerquickacts', function (Blueprint $table) {
                $table->id('treasurerQuickactsID');
                $table->enum('actions', ['approve', 'no'])->default('no');
                $table->unsignedBigInteger('encoderAddmoneyID')->nullable();
                $table->unsignedBigInteger('encoderAddexpensesID')->nullable();
                $table->timestamps();

                $table->foreign('encoderAddmoneyID', 'fk_quickacts_addmoney')
                    ->references('encoderAddmoneyID')->on('encoderaddmoney')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('encoderAddexpensesID', 'fk_quickacts_addexpenses')
                    ->references('encoderAddexpensesID')->on('encoderaddexpenses')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }

        // 10. treasurerreports
        if (!Schema::hasTable('treasurerreports')) {
            Schema::create('treasurerreports', function (Blueprint $table) {
                $table->id('treasurerReportsID');
                $table->unsignedBigInteger('treasurerTransactionsID')->nullable();
                $table->timestamps();

                $table->foreign('treasurerTransactionsID', 'fk_reports_transaction')
                    ->references('treasurerTransactionsID')->on('treasurer_transactions')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }

        // 11. treasurers
        if (!Schema::hasTable('treasurers')) {
            Schema::create('treasurers', function (Blueprint $table) {
                $table->id('treasurersID');
                $table->unsignedBigInteger('treasurerDashboardID')->nullable();
                $table->unsignedBigInteger('treasurerQuickactsID')->nullable();
                $table->unsignedBigInteger('treasurerAddexpensesID')->nullable();
                $table->unsignedBigInteger('treasurerAddmoneyID')->nullable();
                $table->unsignedBigInteger('treasurerTransactionsID')->nullable();
                $table->unsignedBigInteger('usersID');
                $table->timestamps();

                $table->foreign('usersID', 'fk_treasurers_user')
                    ->references('usersID')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

                $table->foreign('treasurerDashboardID', 'fk_treasurers_dashboard')
                    ->references('treasurerDashboardID')->on('treasurer_dashboard')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('treasurerQuickactsID', 'fk_treasurers_quickacts')
                    ->references('treasurerQuickactsID')->on('treasurerquickacts')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('treasurerAddexpensesID', 'fk_treasurers_addexpenses')
                    ->references('treasurerAddexpensesID')->on('treasureraddexpenses')
                    ->onDelete('set null')->onUpdate('cascade');

                $table->foreign('treasurerAddmoneyID', 'fk_treasurers_addmoney')
                    ->references('treasurerAddmoneyID')->on('treasureraddmoney')
                    ->onDelete('set null')->onUpdate('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('treasurers');
        Schema::dropIfExists('treasurerreports');
        Schema::dropIfExists('treasurerquickacts');
        Schema::dropIfExists('treasurer_transactions');
        Schema::dropIfExists('treasurer_dashboard');
        Schema::dropIfExists('treasureraddexpenses');
        Schema::dropIfExists('treasureraddmoney');
        Schema::dropIfExists('encoder_transactions');
        Schema::dropIfExists('encoders');
        Schema::dropIfExists('encoderaddexpenses');
        Schema::dropIfExists('encoderaddmoney');
    }
};
