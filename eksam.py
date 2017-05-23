f = open("jalusis.txt")
andmed = []
andmed2 = []
for rida in f:
    rida = rida.strip().split("kiirusega")
    andmed += rida
    andmed2.append(rida)
#print(andmed) #['3', '8m30s ', ' 9m10s/km', '4m10s ', ' 8m1s/km', '21s ', ' 4m10s/km']
#print(andmed2) #[['3'], ['8m30s ', ' 9m10s/km'], ['4m10s ', ' 8m1s/km'], ['21s ', ' 4m10s/km']]
kiirused = []
for i in range(1,len(andmed2)):
    kiirused.append(andmed2[i][1])
    i += 1
#print(kiirused) #[' 9m10s/km', ' 8m1s/km', ' 4m10s/km']
ajad = []
for i in range(1,len(andmed2)):
    ajad.append(andmed2[i][0])
    i += 1
#print(ajad) #['8m30s ', '4m10s ', '21s ']
puhas = []
for el in kiirused:
    el = el.strip("s/km").split("m")
    puhas.append(el)
#print(puhas) #[[' 9', '10'], [' 8', '1'], [' 4', '10']]  esimene on minut ja teine sekund
puhas2 = []
for el2 in ajad:
    if 'm' not in el2:
        el2 = "0m" + el2[:]
    el3 = el2.strip("s ").split("m")
    puhas2.append(el3)
#print(puhas2) #[['8', '30'], ['4', '10'], ['0', '21']]

kiirused = []
for i in range(0, len(puhas)):
    sekunditeks = int(puhas[i][0]) * 60 + int(puhas[i][1])
    km_h = 3600/sekunditeks
    kiirused.append(km_h)
#print(kiirused)  #km/h [6.545454545454546, 7.484407484407485, 14.4]

aeg_tundides = []
for i in range(0, len(puhas2)):
    sekunditeks = int(puhas2[i][0]) * 60 + int(puhas2[i][1])
    tundides = sekunditeks/3600
    aeg_tundides.append(tundides)
#print(aeg_tundides)  #aeg tundides!! [0.14166666666666666, 0.06944444444444445, 0.005833333333333334]

korrutis = []
for i in range(0, len(kiirused)):
     korrutis.append(kiirused[i]*aeg_tundides[i])
teepikkus = sum(korrutis) * 1000
print(teepikkus)

keskmine_kiirus = (teepikkus/sum(aeg_tundides))/1000
print(keskmine_kiirus)
