<?php


namespace App\Repositories;

use App\Models\Loan;


class LoanRepository implements LoanRepositoryInterface
{
    /**
     * Get's a record by it's ID
     *
     * @param int
     * @return collection
     */
    public function get($id)
    {
        return Loan::find($id);
    }

    /**
     * Get's all records.
     *
     * @return mixed
     */
    public function all()
    {
        return Loan::all();
    }

    /**
     * Deletes a record.
     *
     * @param int
     */
    public function delete($id)
    {
        Loan::destroy($id);
    }

    /**
     * Updates a post.
     *
     * @param int
     * @param array
     */
    public function update($id, array $data)
    {
        Loan::find($id)->update($data);
    }

    public function store(array $loans)
    {
        return Loan::insert($loans);
    }
}
