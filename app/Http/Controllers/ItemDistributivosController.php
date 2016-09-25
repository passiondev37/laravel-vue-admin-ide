<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ItemDistributivoCreateRequest;
use App\Http\Requests\ItemDistributivoUpdateRequest;
use App\Repositories\ItemDistributivoRepository;


class ItemDistributivosController extends Controller
{

    /**
     * @var ItemDistributivoRepository
     */
    protected $repository;

    /**
     * @var ItemDistributivoValidator
     */
    protected $validator;

    public function __construct(ItemDistributivoRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $itemDistributivos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $itemDistributivos,
            ]);
        }

        return view('itemDistributivos.index', compact('itemDistributivos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ItemDistributivoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ItemDistributivoCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $itemDistributivo = $this->repository->create($request->all());

            $response = [
                'message' => 'ItemDistributivo created.',
                'data'    => $itemDistributivo->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $itemDistributivo = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $itemDistributivo,
            ]);
        }

        return view('itemDistributivos.show', compact('itemDistributivo'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $itemDistributivo = $this->repository->find($id);

        return view('itemDistributivos.edit', compact('itemDistributivo'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ItemDistributivoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ItemDistributivoUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $itemDistributivo = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'ItemDistributivo updated.',
                'data'    => $itemDistributivo->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'ItemDistributivo deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ItemDistributivo deleted.');
    }
}
