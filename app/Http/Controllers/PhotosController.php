<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotLoggedInException;
use App\Facades\PhotoDrop;
use App\Photo;
use DSentker\ImageOrientationFixer\ImageOrientationFixer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            PhotoDrop::assertUserIsLoggedIn();
        } catch (UserNotLoggedInException $e) {
            return redirect(route('index'));
        }

        $user = PhotoDrop::getLoggedInUser();

        return view('pages.photos.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            PhotoDrop::assertUserIsLoggedIn();
        } catch (UserNotLoggedInException $e) {
            return redirect(route('index'));
        }

        $user = PhotoDrop::getLoggedInUser();

        return view('pages.photos.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            PhotoDrop::assertUserIsLoggedIn();
        } catch (UserNotLoggedInException $e) {
            return redirect(route('index'));
        }

        /** @var UploadedFile $photo */
        $photo = $request->file('photo');

        $originalFilename = $photo->getClientOriginalName();
        $tempFilename = $photo->getPathname();

        /* Determine whether the file has already been seen */

        $uploadedFiles = Session::get('uploadedFiles', null);
        if (is_null($uploadedFiles)) {
            $uploadedFiles = [];
        } else {
            $uploadedFiles = unserialize($uploadedFiles);
        }

        /* Determine if all chunks of this file have been uploaded */

        $input = $request->all();
        $chunksCount = $input['dztotalchunkcount'] ?? 1;
        $chunkIndex = $input['dzchunkindex'] ?? 0;

        /* Create temporary file to hold chunk contents if necessary */

        if (!isset($uploadedFiles[$originalFilename])) {
            $uploadedFiles[$originalFilename] = $outputFilePath = tempnam(sys_get_temp_dir(), 'pd_');
        } else {
            $outputFilePath = $uploadedFiles[$originalFilename];
        }

        /* Append chunk to output file */

        $outputFile = fopen($outputFilePath, 'ab');
        $inputFile = fopen($tempFilename, 'rb');

        while ($buffer = fread($inputFile, 65536)) {
            fwrite($outputFile, $buffer);
        }

        fclose($inputFile);
        fclose($outputFile);

        /* Determine if all chunks of this file have been uploaded */

        if ($chunkIndex == ($chunksCount - 1)) {
            /* Create Photo */

            $photo = Photo::create([
                'user_id' => PhotoDrop::getLoggedInUser()->id,
                'filename' => $originalFilename
            ]);

            /* Fix EXIF orientation if necessary */

            try {
                ImageOrientationFixer::fixImage($outputFilePath);
            } catch (\Exception $e) {}

            /* Create new UploadedFile instance */

            $uploadedFile = new UploadedFile($outputFilePath, $originalFilename);
            // var_dump($uploadedFile);

            /* Add file to Photo */

            $photo
                ->addMedia($uploadedFile)
                ->toMediaCollection();

            /* Remove file from uploaded files data */

            $uploadedFiles = array_filter($uploadedFiles, function($uploadedFile) use ($outputFilePath) {
                return $uploadedFile != $outputFilePath;
            });

            $photoIsFinished = true;
        } else {
            $photoIsFinished = false;
        }

        /* Write uploaded files data back to the session */

        Session::put('uploadedFiles', serialize($uploadedFiles));

        return Response::json([
            'message' => ($photoIsFinished ? 'Image' : 'Chunk') . ' saved Successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
