<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Repositories\LangValidatorRepository;

class ArticleRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        return [
			'title' => 'required|min:3',
            'body' => 'required',
            'published_at' => 'required|date',
		];
	}

    public function validator(\Illuminate\Validation\Factory $factory){
        return new LangValidatorRepository($factory->getTranslator(),$this->all(),$this->container->call([$this, 'rules']), array(), array(), 'article');
    }
}
