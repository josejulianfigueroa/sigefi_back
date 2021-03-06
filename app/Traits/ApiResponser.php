<?php 
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;



trait ApiResponser

{
	private function successResponse($data, $code){
		return response()->json($data,$code);
	}

	protected function errorResponse($mensaje, $code){
		return response()->json(['error' => $mensaje,'code' => $code], $code);
	}

	protected function showAll(Collection $collection, $code = 200) {

	if ($collection->isEmpty()){
		return $this->successResponse(['data' => $collection],$code);
		}


		$collection = $this->paginateq($collection);

		// return $this->successResponse(['data' => $collection], $code);

		return $this->successResponse($collection, $code);
	}

	protected function showOne(Model $instance, $code = 200) {
		return $this->successResponse(['data' => $instance], $code);
	}


	protected function paginateq(Collection $collection){

		/*$rules = [
			'per_page' => 'integer|min:2|max:50'
		];
*/
		// Validator es un facade
		// Validator::validate(request()->all(), $rules);


		$page  = LengthAwarePaginator::resolveCurrentPage();
		
		$perPage = 5;

		if (request()->has('per_page')) {
			$perPage = (int)request()->per_page;
		}

		$results = $collection->slice(($page -1) * $perPage, $perPage)->values();

		$paginated = new LengthAwarePaginator($results,$collection->count(), $perPage, $page, [

			'path' => LengthAwarePaginator::resolveCurrentPage(),
		]);

		$paginated->appends(request()->all());

		return $paginated;
	}
}