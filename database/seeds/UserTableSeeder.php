<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role_admin = Role::where('name', 'admin')->first();
      $role_user = Role::where('name', 'user')->first();

      $user = new User();
      $user->name = 'Admin';
      $user->last_name = 'Admin';
      $user->udg_code = '222333555';
      $user->career = 'Ingeniería en Informática';
      $user->phone = '3328287716';
      $user->email = 'admin@cryptoudgcoin.com';
      $user->nip = '0000';
      $user->password = bcrypt('Pass123.');
      $user->save();
      $user->roles()->attach($role_admin);

      $mxn = $user->createWallet([
          'name' => 'MXN',
          'slug' => 'mxn_wallet',
      ]);

      $udgc = $user->createWallet([
          'name' => 'UDGC',
          'slug' => 'udgc_wallet',
      ]);

      // Test API Key
      \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
      \Conekta\Conekta::setLocale('es');

      // Prod API Key
      /*
      \Conekta\Conekta::setApiKey("");
      \Conekta\Conekta::setLocale('es');
      */

      $user = User::find($user->id);

      try{
          $customer = \Conekta\Customer::create(
              [
                  'name'  => $user->name,
                  'email' => $user->email,
                  'phone' => $user->phone,
              ]
          );

      }catch (\Conekta\ParameterValidationError $error){
          $bug = $error->getMessage();
          return response()->json(['bug' => $bug], 200);

      } catch (\Conekta\Handler $error){
          $bug = $error->getMessage();
          return response()->json(['bug' => $bug], 200);
      }

      DB::table('users')
          ->where('id', $user->id)
          ->update(['conekta_customer_id' => $customer->id]);

      $user = new User();
      $user->name = 'User';
      $user->last_name = 'User';
      $user->udg_code = '222333555';
      $user->career = 'Ingeniería en Informática';
      $user->phone = '3328287716';
      $user->email = 'user@cryptoudgcoin.com';
      $user->nip = '0000';
      $user->password = bcrypt('Pass123.');
      $user->save();
      $user->roles()->attach($role_user);

      $mxn = $user->createWallet([
          'name' => 'MXN',
          'slug' => 'mxn_wallet',
      ]);

      $udgc = $user->createWallet([
          'name' => 'UDGC',
          'slug' => 'udgc_wallet',
      ]);

      // Test API Key
      \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
      \Conekta\Conekta::setLocale('es');

      // Prod API Key
      /*
      \Conekta\Conekta::setApiKey("");
      \Conekta\Conekta::setLocale('es');
      */

      $user = User::find($user->id);

      try{
          $customer = \Conekta\Customer::create(
              [
                  'name'  => $user->name,
                  'email' => $user->email,
                  'phone' => $user->phone,
              ]
          );

      }catch (\Conekta\ParameterValidationError $error){
          $bug = $error->getMessage();
          return response()->json(['bug' => $bug], 200);

      } catch (\Conekta\Handler $error){
          $bug = $error->getMessage();
          return response()->json(['bug' => $bug], 200);
      }

      DB::table('users')
          ->where('id', $user->id)
          ->update(['conekta_customer_id' => $customer->id]);

      $user = new User();
      $user->name = 'Isaac';
      $user->last_name = 'Sánchez';
      $user->udg_code = '211172172';
      $user->career = 'Ingeniería en Computación';
      $user->phone = '3334590235';
      $user->email = 'isaac@cryptoudgcoin.com';
      $user->nip = '0000';
      $user->password = bcrypt('Pass123.');
      $user->save();
      $user->roles()->attach($role_user);

      $mxn = $user->createWallet([
          'name' => 'MXN',
          'slug' => 'mxn_wallet',
      ]);

      $udgc = $user->createWallet([
          'name' => 'UDGC',
          'slug' => 'udgc_wallet',
      ]);

      // Test API Key
      \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
      \Conekta\Conekta::setLocale('es');

      // Prod API Key
      /*
      \Conekta\Conekta::setApiKey("");
      \Conekta\Conekta::setLocale('es');
      */

      $user = User::find($user->id);

      try{
          $customer = \Conekta\Customer::create(
              [
                  'name'  => $user->name,
                  'email' => $user->email,
                  'phone' => $user->phone,
              ]
          );

      }catch (\Conekta\ParameterValidationError $error){
          $bug = $error->getMessage();
          return response()->json(['bug' => $bug], 200);

      } catch (\Conekta\Handler $error){
          $bug = $error->getMessage();
          return response()->json(['bug' => $bug], 200);
      }

      DB::table('users')
          ->where('id', $user->id)
          ->update(['conekta_customer_id' => $customer->id]);

      $user = new User();
      $user->name = 'David';
      $user->last_name = 'Vega';
      $user->udg_code = '213627657';
      $user->career = 'Ingeniería en Computación';
      $user->phone = '3328708259';
      $user->email = 'david@cryptoudgcoin.com';
      $user->nip = '0000';
      $user->password = bcrypt('Pass123.');
      $user->save();
      $user->roles()->attach($role_user);

      $mxn = $user->createWallet([
          'name' => 'MXN',
          'slug' => 'mxn_wallet',
      ]);

      $udgc = $user->createWallet([
          'name' => 'UDGC',
          'slug' => 'udgc_wallet',
      ]);

      // Test API Key
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        /*
        \Conekta\Conekta::setApiKey("");
        \Conekta\Conekta::setLocale('es');
        */

        $user = User::find($user->id);

        try{
            $customer = \Conekta\Customer::create(
                [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]
            );

        }catch (\Conekta\ParameterValidationError $error){
            $bug = $error->getMessage();
            return response()->json(['bug' => $bug], 200);

        } catch (\Conekta\Handler $error){
            $bug = $error->getMessage();
            return response()->json(['bug' => $bug], 200);
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update(['conekta_customer_id' => $customer->id]);

        // Test API Key
        \Conekta\Conekta::setApiKey("key_NzwBXLzoUJBuZuwF4hqX1w");
        \Conekta\Conekta::setLocale('es');

        // Prod API Key
        /*
        \Conekta\Conekta::setApiKey("");
        \Conekta\Conekta::setLocale('es');
        */

        $user = User::find($user->id);

        try{
            $customer = \Conekta\Customer::create(
                [
                    'name'  => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]
            );

        }catch (\Conekta\ParameterValidationError $error){
            $bug = $error->getMessage();
            return response()->json(['bug' => $bug], 200);

        } catch (\Conekta\Handler $error){
            $bug = $error->getMessage();
            return response()->json(['bug' => $bug], 200);
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update(['conekta_customer_id' => $customer->id]);
    }
}
