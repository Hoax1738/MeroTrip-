<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Auth;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,Notifiable;
    protected $fillable = [
        'name', 'email', 'password','user_detail','referrer','balance','contact'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public static function myPayments($request,$user_id,$invoice_id = null){
        $id=$user_id;
        return DB::table('payments')
            ->join('invoice', 'payments.invoice_id', '=', 'invoice.id')
            ->join('commits', 'invoice.commit_id', '=', 'commits.id')
            ->join('commence_dates', 'commence_dates.id', '=', 'commits.commence_date_id')
            ->join('packages', 'packages.id', '=', 'commence_dates.package_id')
            ->where('payments.user_id', $id)
            ->select(
                'payments.*',
                'payments.id as payment_id',
                'payments.status as payment_status',
                'invoice.*',
                'invoice.status as invoice_status',
                'invoice.note as invoice_note',
                'commits.*',
                'commits.status as commits_status',
                'packages.title as package_title',
                'packages.slug as package_slug',
                'commence_dates.commence_date as commence_date'
            )
           ->when($invoice_id,function($q,$invoice_id){
                $q->where('payments.invoice_id',$invoice_id);
           })
           ->when($request->title,function($q,$status){
            $q->where('packages.title',$status);
            })
           ->when($request->type,function($q,$status){
                $q->where('type',$status);
           })
           ->when($request->method,function($q,$status){
                $q->where('method',$status);
           })->orderBy('payments.id','asc')->paginate(5);
    }

    public static function myPackageField($field,$user_id){
        $id=$user_id;
        return DB::table('payments')
            ->join('invoice', 'payments.invoice_id', '=', 'invoice.id')
            ->join('commits', 'invoice.commit_id', '=', 'commits.id')
            ->join('commence_dates', 'commence_dates.id', '=', 'commits.commence_date_id')
            ->join('packages', 'packages.id', '=', 'commence_dates.package_id')
            ->where('payments.user_id',$id)
            ->select(
                $field,
            )
            ->distinct($field)
            ->get();
    }


    public static function lastPaid($commitment_id,$user_id=null,$kernel=null){
        return DB::table('invoice')
            ->when(Auth::check() && Auth::user()->hasRole('customer'),function($q){
                return $q->where('invoice.user_id', Auth::user()->id);
            })
            ->when(Auth::check() && Auth::user()->hasRole('admin'),function($q) use($user_id){
                return $q->where('invoice.user_id', $user_id);
            })
            ->when($kernel,function($q) use($user_id){
                return $q->where('invoice.user_id', $user_id);
            })

            ->where('invoice.commit_id', $commitment_id)
            ->where('invoice.status', "paid")
            ->whereIn('invoice.type', array("installment","down_payment"))
            ->select('invoice.due')
            ->latest()
            ->first();
    }
    public static function paymentsForSingleCommit($id,$fields,$user_id=null){

        $payments = DB::table('invoice')
            ->join('payments', 'payments.invoice_id', '=', 'invoice.id')
            ->join('commits', 'commits.id', '=', 'invoice.commit_id')
            ->where('commits.id', $id)
            ->when(Auth::user()->hasRole('customer'),function($q){
                return $q->where('commits.user_id', Auth::user()->id);
            })
            ->when(Auth::user()->hasRole('customer'),function($q){
                return $q->where('payments.user_id', Auth::user()->id);
            })
            ->when(Auth::user()->hasRole('customer'),function($q){
                return $q->where('invoice.user_id', Auth::user()->id);
            })

            ->when(Auth::user()->hasRole('admin'),function($q) use($user_id){
                return $q->where('commits.user_id', $user_id);

            })
            ->when(Auth::user()->hasRole('admin'),function($q) use($user_id){
                return $q->where('payments.user_id', $user_id);
            })
            ->when(Auth::user()->hasRole('admin'),function($q) use($user_id){
                return $q->where('invoice.user_id', $user_id);
            })

            ->where('payments.status', "completed")
            ->where('invoice.status', "paid")
            ->whereIn('invoice.type', $fields)
            ->sum('invoice.amount');
        return $payments;
    }
    public static function singleCommitInfo($id,$user_id=null){
        $commitment = DB::table('commits')
            ->join('commence_dates', 'commits.commence_date_id', '=', 'commence_dates.id')
            ->join('packages', 'commence_dates.package_id', '=', 'packages.id')
            ->when(Auth::user()->hasRole('customer'),function($q){
                return $q->where('commits.user_id', Auth::user()->id);
            })
            ->when(Auth::user()->hasRole('admin'),function($q) use($user_id){
                return $q->where('commits.user_id', $user_id);
            })
            ->where('commits.id', $id)
            ->where('commits.status', '!=', 'abandoned')
            ->select('commits.*','commence_dates.package_id','commence_dates.commence_date','commence_dates.price','packages.title','packages.slug')
            ->first();

        return $commitment;
    }
    public static function myCommitments(){
        $commitments = DB::table('commits')
            ->join('commence_dates', 'commits.commence_date_id', '=', 'commence_dates.id')
            ->join('packages', 'commence_dates.package_id', '=', 'packages.id')
            ->where('commits.user_id', Auth::user()->id)
            ->where('commits.status', '!=', 'abandoned')
            ->select(
                'commits.*',
                'commits.id as commit_id',
                'commence_dates.package_id',
                'commence_dates.commence_date',
                'commence_dates.price',
                'packages.title',
                'packages.slug',
                'packages.images')
            ->get();
        return $commitments;
    }
    public static function eligibleToBook($package,$user_id=null){ // accepts singleCommenceDateInfo();

       $user_id=isset($user_id)?$user_id:Auth::user()->id;
       $commits = DB::table('commits')
            ->where('user_id', $user_id)
            ->where('commence_date_id', $package[0]['id'])
            ->where(function ($query) {
                    $query->where('status', 'active')
                    ->orWhere('status', 'pending');
            })
            ->select('*')
            ->count();
        if($commits==0)
            return array(true);
        else
            return array(false,"You have either active or pending commitment for this commence date. Please check <a href=\"".route('MyCommitments')."\">My Commitments</a> for more");
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function authorizeRoles($roles){
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) ||
                    abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles) ||
                abort(401, 'This action is unauthorized.');
    }
    public function hasAnyRole($roles){
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    public function hasRole($role){
        return null !== $this->roles()->where('name', $role)->first();
    }

    public static function updateBalance($user_id,$bonus)
    {
            // dd($user_id);
        $user = DB::table('users')->where('id',$user_id)->first();
        $total_balance = $user->balance;

        $new_balance = $total_balance + $bonus;

        User::where('id', $user_id)
            ->update([
                'balance' => $new_balance,
            ]);

        // dd($total_balance);
    }
}
