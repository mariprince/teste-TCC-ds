<table class="table table-bordered table-hover">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Data Saída</th>
                            <th>Estimativa Entrega</th>
                            <th>Cep Origem</th>
                            <th>Endereço Origem</th>
                           
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php// if (!empty($cotacao) && is_array($cotacao)): ?>
                            <?php //foreach ($cotacao as $cota): ?>
                                <tr>
                                    <td><?= $cota->id_cotacao ?></td>
                                    <td><?= htmlspecialchars($cota->data_saida) ?></td>
                                    <td><?= htmlspecialchars($cota->estimativa_entrega) ?></td>
                                    <td><?= htmlspecialchars($cota->cep_origem) ?></td>
                                    <td><?= htmlspecialchars($cota->endereco_origem) ?></td>
                                    <td>
                                        <a href="../cotacao2.php?metodo=alterar&tipo=cotacao&id=<?=// $cota->id_cotacao ?>"
                                            class="btn btn-sm btn-warning">Editar</a>
                                        <a href="../cotacao2.php?metodo=excluir&tipo=cotacao&id=<?=// $cota->id_cotacao ?>"
                                            class="btn btn-sm btn-danger">Excluir</a>
                                    </td>
                                </tr>
                            <?php// endforeach; ?>
                        <?php //else: ?>
                            <tr>
                                <td colspan="14" class="text-center">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php// endif; ?>
                    </tbody>
                </table>