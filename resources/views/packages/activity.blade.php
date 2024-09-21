<div>
  <table>
    <thead>
      <th>Activity</th>
      @foreach($noClasses as $class)
        {{ dd($class) }}
        <th>No. Classes {{ $class }}</th>
      @endforeach
    </thead>
    <tbody>
      <tr>
        <td>{{ $package->activity->name }}</td>
        @foreach ($packages as $package)
          <td>{{ $package->price }}</td>
        @endforeach
      </tr>
    </tbody>
  </table>
</div>

<div>
  <form action="{{ route('packages.create', $activity_id) }}" method="POST">
    @csrf
    <label for="no_classes">No classes</label>
    <input type="number" name="no_classes" />
    <label for="price">Price</label>
    <input type="number" name="price" />
    <input type="hidden" name="activity_id" value="{{ $activity_id }}" />
    <input type="submit" value="Create" />
  </form>
</div>