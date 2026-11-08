@php
    $isEdit = isset($client);
    $rawAddress = old('address', $client->address ?? '');
    $addressParts = [
        'cep' => '',
        'street' => '',
        'number' => '',
        'complement' => '',
        'district' => '',
        'city' => '',
        'state' => '',
    ];

    if ($rawAddress !== '') {
        $segments = array_values(array_filter(array_map('trim', explode(' - ', $rawAddress)), fn ($segment) => $segment !== ''));
        $cepSegment = array_pop($segments) ?? '';

        if ($cepSegment !== '' && ! str_starts_with(strtoupper($cepSegment), 'CEP ')) {
            $segments[] = $cepSegment;
            $cepSegment = '';
        }

        $cityState = array_pop($segments) ?? '';

        if ($cityState !== '' && ! str_contains($cityState, '/')) {
            $segments[] = $cityState;
            $cityState = '';
        }

        $streetAndNumber = array_shift($segments) ?? '';
        $complement = '';
        $district = '';

        if (count($segments) === 1) {
            $district = $segments[0];
        } elseif (count($segments) > 1) {
            $district = array_pop($segments);
            $complement = implode(' - ', $segments);
        }

        if ($streetAndNumber !== '') {
            if (str_contains($streetAndNumber, ',')) {
                [$street, $number] = array_map('trim', explode(',', $streetAndNumber, 2));
                $addressParts['street'] = $street;
                $addressParts['number'] = $number;
            } else {
                $addressParts['street'] = $streetAndNumber;
            }
        }

        $addressParts['complement'] = $complement;
        $addressParts['district'] = $district;

        if ($cityState !== '' && str_contains($cityState, '/')) {
            [$city, $state] = array_map('trim', explode('/', $cityState, 2));
            $addressParts['city'] = $city;
            $addressParts['state'] = strtoupper(substr($state, 0, 2));
        }

        if ($cepSegment !== '') {
            $addressParts['cep'] = preg_replace('/\D/', '', preg_replace('/^CEP\s+/i', '', $cepSegment));
        }
    }
@endphp

<section class="rounded-3xl border border-[#e1e2e9] bg-white p-6 shadow-[0_4px_16px_rgba(25,28,30,0.05)] md:p-8">
    <form action="{{ $isEdit ? route('clients.update', $client) : route('clients.store') }}" method="POST" class="space-y-5" data-client-form>
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-[#44474f]">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name', $client->name ?? '') }}" required autofocus class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
            @error('name')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="document" class="mb-2 block text-sm font-medium text-[#44474f]">Documento</label>
            <input id="document" name="document" type="text" value="{{ old('document', $client->document ?? '') }}" placeholder="CPF ou CNPJ" required class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
            <p class="mt-2 text-xs text-[#73777f]">CPF ou CNPJ</p>
            @error('document')
                <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-[#44474f]">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email', $client->email ?? '') }}" class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('email')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="mb-2 block text-sm font-medium text-[#44474f]">Telefone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $client->phone ?? '') }}" class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]" />
                @error('phone')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-4">
            <div class="md:col-span-1">
                <label for="cep" class="mb-2 block text-sm font-medium text-[#44474f]">CEP</label>
                <input
                    id="cep"
                    name="cep"
                    type="text"
                    inputmode="numeric"
                    autocomplete="postal-code"
                    value="{{ old('cep', $addressParts['cep']) }}"
                    placeholder="00000-000"
                    maxlength="9"
                    data-cep-field
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
                <p class="mt-2 text-xs text-[#73777f]">Digite o CEP para preencher automaticamente.</p>
            </div>

            <div class="md:col-span-3">
                <label for="street" class="mb-2 block text-sm font-medium text-[#44474f]">Endereço</label>
                <input
                    id="street"
                    name="street"
                    type="text"
                    value="{{ old('street', $addressParts['street']) }}"
                    autocomplete="address-line1"
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
                @error('address')
                    <p class="mt-2 text-sm text-[#ba1a1a]">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-4">
            <div>
                <label for="number" class="mb-2 block text-sm font-medium text-[#44474f]">Número</label>
                <input
                    id="number"
                    name="number"
                    type="text"
                    value="{{ old('number', $addressParts['number']) }}"
                    autocomplete="address-line2"
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
            </div>

            <div class="md:col-span-3">
                <label for="complement" class="mb-2 block text-sm font-medium text-[#44474f]">Complemento</label>
                <input
                    id="complement"
                    name="complement"
                    type="text"
                    value="{{ old('complement', $addressParts['complement']) }}"
                    autocomplete="address-line3"
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            <div>
                <label for="district" class="mb-2 block text-sm font-medium text-[#44474f]">Bairro</label>
                <input
                    id="district"
                    name="district"
                    type="text"
                    value="{{ old('district', $addressParts['district']) }}"
                    autocomplete="address-level3"
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
            </div>

            <div>
                <label for="city" class="mb-2 block text-sm font-medium text-[#44474f]">Cidade</label>
                <input
                    id="city"
                    name="city"
                    type="text"
                    value="{{ old('city', $addressParts['city']) }}"
                    autocomplete="address-level2"
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
            </div>

            <div>
                <label for="state" class="mb-2 block text-sm font-medium text-[#44474f]">Estado</label>
                <input
                    id="state"
                    name="state"
                    type="text"
                    value="{{ old('state', $addressParts['state']) }}"
                    maxlength="2"
                    autocomplete="address-level1"
                    class="w-full rounded-xl border border-[#74777f] px-4 py-3 text-[#1a1b20] uppercase outline-none focus:border-[#006a6a] focus:ring-4 focus:ring-[#c3f0ed]"
                />
            </div>
        </div>

        <input type="hidden" name="address" value="{{ e($rawAddress) }}" data-address-field />

        <div class="flex flex-wrap gap-3 pt-2">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#006a6a] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#005454]">
                <span class="material-symbols-outlined">save</span>
                Salvar
            </button>

            <a href="{{ route('clients.index') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#74777f] px-5 py-3 text-sm font-bold text-[#44474f] transition hover:bg-[#f8f9ff]">
                <span class="material-symbols-outlined">close</span>
                Cancelar
            </a>
        </div>
    </form>

    <script>
        (() => {
            const form = document.querySelector('[data-client-form]');

            if (!form) {
                return;
            }

            const cepInput = form.querySelector('[data-cep-field]');
            const addressField = form.querySelector('[data-address-field]');
            const streetInput = form.querySelector('#street');
            const numberInput = form.querySelector('#number');
            const complementInput = form.querySelector('#complement');
            const districtInput = form.querySelector('#district');
            const cityInput = form.querySelector('#city');
            const stateInput = form.querySelector('#state');

            const composeAddress = () => {
                const segments = [];
                const streetAndNumber = [streetInput.value.trim(), numberInput.value.trim()].filter(Boolean).join(', ');

                if (streetAndNumber) {
                    segments.push(streetAndNumber);
                }

                if (complementInput.value.trim()) {
                    segments.push(complementInput.value.trim());
                }

                if (districtInput.value.trim()) {
                    segments.push(districtInput.value.trim());
                }

                const cityState = [cityInput.value.trim(), stateInput.value.trim().toUpperCase()].filter(Boolean).join('/');
                if (cityState) {
                    segments.push(cityState);
                }

                const cepDigits = cepInput.value.replace(/\D/g, '').slice(0, 8);
                if (cepDigits.length === 8) {
                    const cepFormatted = cepDigits.replace(/^(\d{5})(\d{3})$/, '$1-$2');
                    segments.push(`CEP ${cepFormatted}`);
                }

                addressField.value = segments.join(' - ');
            };

            const hydrateAddressFields = () => {
                const storedAddress = addressField.value.trim();

                if (!storedAddress) {
                    return;
                }

                const segments = storedAddress
                    .split(' - ')
                    .map((segment) => segment.trim())
                    .filter(Boolean);

                let cepSegment = segments.pop() || '';
                if (!/^CEP\s+/i.test(cepSegment)) {
                    if (cepSegment) {
                        segments.push(cepSegment);
                    }
                    cepSegment = '';
                }

                let cityState = segments.pop() || '';
                if (cityState && !cityState.includes('/')) {
                    segments.push(cityState);
                    cityState = '';
                }

                const streetAndNumber = segments.shift() || '';
                let complement = '';
                let district = '';

                if (segments.length === 1) {
                    district = segments[0];
                } else if (segments.length > 1) {
                    district = segments.pop();
                    complement = segments.join(' - ');
                }

                if (streetAndNumber) {
                    const [street = '', number = ''] = streetAndNumber.split(',', 2).map((part) => part.trim());
                    streetInput.value = street || streetInput.value;
                    numberInput.value = number || numberInput.value;
                }

                complementInput.value = complement || complementInput.value;
                districtInput.value = district || districtInput.value;

                if (cityState) {
                    const [city = '', state = ''] = cityState.split('/', 2).map((part) => part.trim());
                    cityInput.value = city || cityInput.value;
                    stateInput.value = state ? state.toUpperCase() : stateInput.value;
                }

                if (cepSegment) {
                    cepInput.value = cepSegment.replace(/^CEP\s+/i, '').trim();
                    cepInput.value = formatCep(cepInput.value);
                }
            };

            const formatCep = (value) => {
                const digits = value.replace(/\D/g, '').slice(0, 8);

                if (digits.length > 5) {
                    return digits.replace(/^(\d{5})(\d{0,3})$/, '$1-$2').replace(/-$/, '');
                }

                return digits;
            };

            const fillFromCep = async () => {
                const cepDigits = cepInput.value.replace(/\D/g, '');

                if (cepDigits.length !== 8) {
                    return;
                }

                const response = await fetch(`https://viacep.com.br/ws/${cepDigits}/json/`);
                if (!response.ok) {
                    return;
                }

                const data = await response.json();

                if (data.erro) {
                    return;
                }

                streetInput.value = data.logradouro || streetInput.value;
                districtInput.value = data.bairro || districtInput.value;
                cityInput.value = data.localidade || cityInput.value;
                stateInput.value = (data.uf || stateInput.value).toUpperCase();

                composeAddress();
            };

            cepInput.addEventListener('input', () => {
                cepInput.value = formatCep(cepInput.value);
                composeAddress();
            });

            [streetInput, numberInput, complementInput, districtInput, cityInput, stateInput].forEach((input) => {
                input.addEventListener('input', composeAddress);
            });

            cepInput.addEventListener('blur', fillFromCep);
            form.addEventListener('submit', () => {
                composeAddress();
            });

            hydrateAddressFields();
            composeAddress();
        })();
    </script>
</section>
