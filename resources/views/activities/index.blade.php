<div>
  <table>
    <thead>
      <th>Activity</th>
      @foreach($noClasses as $class) 
        <th>No. Classes {{ $class }}</th>
      @endforeach
    </thead>
    <tbody>
      @foreach ($activities as $activity)
        <tr>
          <td>
            <a href="{{ route('packages.activity', $activity->id) }}">{{ $activity->name }}</a>
          </td>
          @foreach ($noClasses as $noClass)
            @if($activity->packages->contains('no_classes', $noClass))
              <td>{{ $activity->packages->where('no_classes', $noClass)->first()->price }}</td>
            @else
              <td></td>
            @endif
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div>
  <form action="{{ route('activities.create') }}" method="POST">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" />
    <label for="no_classes">No classes</label>
    <input type="number" name="no_classes" />
    <label for="price">Price</label>
    <input type="number" name="price" />
    <input type="submit" value="Create" />
  </form>
</div>